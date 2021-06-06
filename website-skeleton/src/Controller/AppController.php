<?php
    namespace App\Controller;
    use App\Repository\ProductRepository;
    use App\Service\DataHandler;
    use App\Service\NotificationHandler;
    use Psr\Log\LoggerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Symfony\Component\Routing\Annotation\Route;
    use App\Service\Checker;


    class AppController extends AbstractController
    {
        /**
         * Controller for homepage
         * @Route("/servisni-knizka", name="appMain")
         */
        public function appMain(Request $request, SessionInterface $session){
            // Creating route session based on selected service
            $routeTarget = $request->query->get('route');
            if($routeTarget == "car-fix"){
                $session->set('routeTarget', "car-fix");
                $serviceName = "Servisní úkon";
            }else{
                $session->set('routeTarget', "car-check");
                $serviceName = "Technická prohlídka";
            }
            return $this->render('app/taskMain.html.twig', [
                'actMenu_taskMain' => 'active',
                'serviceName' => $serviceName,
            ]);
        }

        /**
         * Controller for generating form
         * @Route("/servisni-knizka/provedeni/", name="appCompletion")
         */
        public function appCompletion(Request $request, SessionInterface $session, DataHandler $dataHandler, ProductRepository $productRepo){
            $codeErrMsg = "Zadaný kód neexistuje.";
            $code = '';

            if(empty($request->request->get('code'))){
                // From GET request (only when returning with error)
                $code = strtoupper($request->query->get('code'));
            }else{
                // From POST request (main way to obtain order code)
                $code = strtoupper($request->request->get('code'));
                $session->set('code', $request->request->get('code'));
            }
            $userData = $dataHandler->getUserByBookID($code);
            $checklist = json_decode($productRepo->findOneBy(['alias' => 'virtBook'])->getChecklist(), true);

            // Verifying bookID -> checks if exists, if not REDIRECTS to main page with error
            if($userData == ""){
                // Creates one use error msg
                $this->addFlash('codeErrMsg', $codeErrMsg);
                // Redirects back to origin route
                return $this->redirectToRoute('appMain', ['route' => $session->get('routeTarget')]);
            }

            $session->set('userID', $userData['userID']);
            $session->set('appChecklist', $checklist);
            $taskData = [
                'taskNum' => $code,
                'product' => $checklist,
            ];

            // Loads input values filled before form error
            if(empty($session->get('memData'))){
                $memData = [];
            }else{
                $memData = $session->get('memData');
            }

            // Routing based on selected service
            if($session->get('routeTarget') == "car-check"){
                return $this->render('app/taskCompletion/taskCompletion_base.html.twig', [
                    'taskData' => $taskData,
                    'memData' => $memData,
                ]);
            }else{
                return $this->render('app/carFixForm/carFixCompletion.html.twig', [
                    'taskData' => $taskData,
                    'memData' => $memData,
                ]);
            }
        }

        /**
         * Checks and saves task data for CAR-FIX
         * @Route("/servisni-knizka/odeslano/ukon", name="fixSave")
         */
        public function fixSave(Request $request, DataHandler $dataHandler, SessionInterface $session, NotificationHandler $notificationHandler){
            $successMsg = "Servisní úkon byl úspěšně odeslán.";
            $kmErrMsg = " Prosím překontrolujte počet najetých KM. Počet najetých KM nemůže být nižší než při předchozím zadání.";
            $emptyErrMsg = 'Prosím vyplňte všechna pole.';
            $isError = false;
            $memData = []; // Array for input values to remember if form is submitted with errors
            $finalFormData = [
                "repairAddress" => "Autoservis Kolečko, Dlouhá 55, Praha 4",
                "repairDate" => time()*1000,
            ]; // Array for data to be saved in DB

            // Data
            $formData = $request->request->all();
            $kmTotal = $dataHandler->getData($session->get('userID'),["carData", "stats", "kmTotal"]);

            // Check inputs
            foreach($formData as $index => $data){
                if (empty($data)){
                    $isError = true;
                    $this->addFlash('emptyErrMsg', $emptyErrMsg);
                }elseif($index == "repairKm" && $data < $kmTotal){
                    $isError = true;
                    $this->addFlash('kmErrMsg', $kmErrMsg);
                    $memData[$index] = $data;
                }elseif($index == "repairArea" || $index == "repairDesc" || $index == "repairName"){
                    // Adding data with specific name into final array
                    $finalFormData[$index] = htmlspecialchars(strip_tags($data));
                    $memData[$index] = $data;
                }elseif($index == "repairKm" || $index = "repairPrice"){
                    // Adding data with specific name into final array
                    $finalFormData[$index] = intval(htmlspecialchars(strip_tags($data))); // If number -> convert str to int
                    $memData[$index] = $data;
                }else{
                    $isError = true;
                    $this->addFlash('emptyErrMsg', $emptyErrMsg);
                }
            }

            // Refresh old data in session
            $session->remove('memData');

            // Handling errors
            if($isError){
                // Returns and calls errors if form isn't filled correctly
                $session->set('memData', $memData);
                return $this->redirectToRoute('appCompletion', ['code' => $session->get('code')]);
            }else{
                // Saves into db and redirects with success message if form is filled correctly
                // Saving data
                $dataHandler->getCronNotifTokens();
                $dataHandler->insertData($finalFormData, $session->get('userID'),"carData.repairHistory", true);
                $dataHandler->insertData($finalFormData["repairKm"], $session->get('userID'), 'carData.stats.kmTotal');
                $dataHandler->insertData($dataHandler->addIntegerData($finalFormData["repairPrice"], $session->get('userID'), ['carData','stats','costsTotal']), $session->get('userID'), 'carData.stats.costsTotal');
                $dataHandler->insertData($dataHandler->addIntegerData(1, $session->get('userID'), ['carData','stats','repairsTotal']), $session->get('userID'), 'carData.stats.repairsTotal');

                // Sends app notification
                $notificationHandler->sendNotif([$dataHandler->getData($session->get('userID'), ["notificationToken"])], "🚗 Servisní úkon zapsán!", "Prohlédněte si podrobnosti úkonu v appce.");

                // Routing with success
                $this->addFlash('successMsg', $successMsg);
                return $this->redirectToRoute('appMain',["route" => "car-fix"]);
            }
        }

        /**
         * Checks and saves task data for CAR-CHECK
         * @Route("/servisni-knizka/odeslano/prohlidka", name="appSave")
         */
        public function appSave(Request $request, SessionInterface $session, Checker $checker, DataHandler $dataHandler, NotificationHandler $notificationHandler, LoggerInterface $logger){
            $successMsg = 'Prohlídka byla úspěšně odeslána.';
            $checkboxErrMsg = 'Prosím popište závadu blíže v poznámce.';
            $emptyErrMsg = 'Prosím vyplňte taktéž toto pole.';
            $isErrorMsg = 'Některá pole nejsou vyplněna správně a nedošlo k odeslání. U daného pole najdete detaily.';
            $kmErrMsg = " Prosím překontrolujte počet najetých KM. Počet najetých KM nemůže být nižší než při předchozím zadání.";
            $isError = false;
            $memData = []; // Array for input values to remember if form is submitted with errors
            $statsData = [];
            $kmTotal = $dataHandler->getData($session->get('userID'),["carData", "stats", "kmTotal"]);

            // Data
            $taskData = $request->request->all();
            // Checklist without data
            $product = $session->get('appChecklist');
            $carErrorsTotal = 0;

            // Loops thru checklist and adds data to it
            foreach ($product['productChecklist'] as $inrKey => $checkArea){
                foreach($product['productChecklist'][$inrKey]['checkAreaChecklist'] as $inrinrKey => $checklist){
                    // Switch for different inputTypes of check point
                    switch ($checklist['inputType']){
                        case 'text':
                        case 'number':
                        case 'datePickerYear':
                        case 'select':
                            // Security html and sql strip
                            $input = htmlspecialchars(strip_tags($taskData[$checklist['alias']]));

                            // Checks input, inserts into checklist array and remembers values for case of error
                            if(!empty($input)){
                                // Datetime to timestamp (milliseconds)
                                if($checklist['inputType'] == 'datePickerYear'){
                                    $input = strtotime($input)*1000;
                                }

                                // Dividing data and saving into JSON (for car check) or array (for car stats)
                                if($product['productChecklist'][$inrKey]['checkAreaAlias'] == "certifAutomato-carBasicInfo"){
                                    if($checklist['alias'] == "kmTotal" && $input < $kmTotal){
                                        $this->addFlash('kmErrMsg-'.$checklist['alias'], $kmErrMsg);
                                        $isError = true;
                                    }else{
                                        $statsData[$checklist["alias"]] = $input;
                                    }
                                }else{
                                    $product['productChecklist'][$inrKey]['checkAreaChecklist'][$inrinrKey]['value'] = $input;
                                }

                                // Remembering value for case of error --> input type SELECT
                                if($checklist['inputType'] == 'select'){
                                    foreach ($product['productChecklist'][$inrKey]['checkAreaChecklist'][$inrinrKey]['selectOption'] as $option){
                                        if($option['optionName'] == $input){
                                            // Not using $checker->inputMem, because of different alias in POST and in mem checklist
                                            $memData[$option['optionAlias']] = $option['optionName'];
                                        }
                                    }
                                }else{
                                    $memData = $checker->inputMem($memData, $checklist['alias'], $taskData);
                                }
                            }else{
                                $this->addFlash('emptyErrMsg-'.$checklist['alias'], $emptyErrMsg);
                                $isError = true;
                            }
                            break;
                        case 'checkBox':
                            $inputBool = htmlspecialchars(strip_tags($taskData[$checklist['alias'].'-bool']));
                            $inputNote = htmlspecialchars(strip_tags($taskData[$checklist['alias'].'-note']));

                            // Checks BOOL and NOTE. Remembers values for case of error
                            if($inputBool == 1 && empty($inputNote)){
                                // Checkbox checked without note
                                $this->addFlash('checkboxErrMsg-'.$checklist['alias'], $checkboxErrMsg);
                                $isError = true;
                                $memData = $checker->inputMem($memData, $checklist['alias'].'-bool', $taskData);
                            }elseif($inputBool == 1){
                                // Checkbox checked with note
                                // Adds bool and note into array and memory
                                $product['productChecklist'][$inrKey]['checkAreaChecklist'][$inrinrKey]['value']['bool'] = $inputBool;
                                $product['productChecklist'][$inrKey]['checkAreaChecklist'][$inrinrKey]['value']['note'] = $inputNote;
                                $memData = $checker->inputMem($memData, $checklist['alias'].'-bool', $taskData);
                                $memData = $checker->inputMem($memData, $checklist['alias'].'-note', $taskData);
                                // Counting car errors
                                $carErrorsTotal++;
                            }else{
                                // Checkbox unchecked
                                $product['productChecklist'][$inrKey]['checkAreaChecklist'][$inrinrKey]['value'] = [
                                    'note' => '',
                                    'bool' => $inputBool,
                                ];
                            }
                            break;
                    }
                }
            }

            // Refresh old data in session
            $session->remove('memData');

            // Handling errors
            if($isError){
                // Returns and calls errors if form isn't filled correctly
                $session->set('memData', $memData);
                $this->addFlash('isErrorMsg', $isErrorMsg);
                return $this->redirectToRoute('appCompletion',['code' => $session->get('code')]);
            }else{
                // Saves into db and redirects with success message if form is filled correctly

                //Saving data
                $dataHandler->insertData(json_encode($product), $session->get('userID'),"carData.carCheck");
                $statsData["errorsTotal"] = $carErrorsTotal;
                $dataHandler->insertCarStats($statsData, $session->get('userID'));

                // Sends app notification
                $notificationHandler->sendNotif([$dataHandler->getData($session->get('userID'), ["notificationToken"])], "🚗 Prohlídka je hotova!", "Prohlédněte si stav vozidla v appce.");

                // Memory reset, routing with success
                $session->remove('appChecklist');
                $this->addFlash('successMsg', $successMsg);
                return $this->redirectToRoute('appMain');
            }
        }
    }