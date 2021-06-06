<?php
namespace App\Service;
use Google\Cloud\Firestore\FirestoreClient;
use Symfony\Component\Config\Definition\Exception\Exception;

class DataHandler
{
    protected $db;

    /*DB CONNECTION*/
    function __construct()
    {
        $keyFilePath = explode('src',dirname(__FILE__))[0];

        // db connection setup
        $this->db = new FirestoreClient([
            'projectId' => 'virtbook-69420',
            'keyFilePath' =>  $keyFilePath.'devToken/VirtBook-a28c592d69f6.json',
        ]);
    }

    /*GETTERS*/
    // Basic data Getter
    public function getData($userID, $indexArr){
        $doc = $this->db->collection("users")->document($userID)->snapshot();
        try{
            $data = $doc->data();
            foreach($indexArr as $index){
                $data = $data[$index];
            }
            return $data;
        }catch(\Exception $e){
            return 0;
        }
    }

    // Gets user data by book ID (id of users app)
    public function getUserByBookID($bookID){
        $usersRef = $this->db->collection("users");
        try{
            $snapshot = $usersRef->where("bookID","==", $bookID)->documents()->rows()[0];
            $userData = $snapshot->data();
            $userData['userID'] = $snapshot->id();
            return $userData;
        }catch(\Exception $e){
            return "";
        }
    }

    // Gets original data from DB, adds it to the value and returns it
    public function addIntegerData($data, $userID, $indexArr){
        return $this->getData($userID, $indexArr) + $data;
    }

    // Gets tokens of users to be notified by CRON
    public function getCronNotifTokens(){
        $notifTokens = [];
        $notifDate = date("d.m.Y", strtotime("+1 month")); // Today + one month -> So user gets notified one month before

        try{
            $usersRef = $this->db->collection("users")->documents()->rows();
            foreach($usersRef as $userRef){
                $reminders = $userRef->data()['carData']['reminders'];
                $userNotifToken = $userRef->data()['notificationToken'];

                // Comparing reminders with today + one month
                // Oil change reminder
                if(date("d.m.Y", $reminders['dateOilChange']/1000) == $notifDate){
                    $notifTokens[] = ["reminderType" => "dateOilChange", "notifToken" => $userNotifToken];
                }
                // STK reminder
                if(date("d.m.Y", $reminders['dateSTK']/1000) == $notifDate){
                    $notifTokens[] = ["reminderType" => "dateSTK", "notifToken" => $userNotifToken];
                }
                // KM technical check reminder
                if( $reminders['kmNextCheck'] <= 500){
                    $notifTokens[] = ["reminderType" => "kmNextCheck", "notifToken" => $userNotifToken];
                }
            }
            return $notifTokens;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /*SETTERS*/
    // Basic data Setter - $appendArr = TRUE appends data to array in DB / FALSE updated DB with data
    public function insertData($data, $userID, $index, $appendArr = false){
        try{
            if($appendArr){
                $repHisArr = $this->getData($userID, ["carData", "repairHistory"]);
                $repHisArr[] = $data;
                $this->db->collection('users')->document($userID)->update([
                    ["path" => $index, "value" => $repHisArr]
                ]);
            }else{
                $this->db->collection('users')->document($userID)->update([
                    ["path" => $index, "value" => $data]
                ]);
            }
            return $this;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    // Inserts stats about car into db
    public function insertCarStats($data, $userID){
        try{
            $costsTotal = $this->addIntegerData(intval($data["fixPrice"]), $userID, ["carData","stats","costsTotal"]);
            $this->db->collection('users')->document($userID)->update([
                ["path" => "carData.reminders.dateOilChange", "value" => $data["dateOilChange"]],
                ["path" => "carData.reminders.dateSTK", "value" => $data["dateSTK"]],
                ["path" => "carData.reminders.kmNextCheck", "value" => intval($data["kmNextCheck"])],
                ["path" => "carData.stats.kmTotal", "value" => intval($data["kmTotal"])],
                ["path" => "carData.stats.costsTotal", "value" => $costsTotal],
                ["path" => "carData.stats.errorsTotal", "value" => intval($data["errorsTotal"])],
                ["path" => "carData.stats.fixPrice", "value" => intval($data["fixPrice"])]
            ]);
            return $this;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}