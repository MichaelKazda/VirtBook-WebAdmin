<?php
    namespace App\Cron;
    use App\Service\DataHandler;
    use App\Service\NotificationHandler;

    // Handler objects
    $dataHandler = new DataHandler();
    $notifHandler = new NotificationHandler();

    // Getting notification tokens of users ready to be notify
    $notifTokensArr = $dataHandler->getCronNotifTokens();

    // Dividing notification tokens to arrays based on reminder types
    $notifTokensOil = [];
    $notifTokensSTK = [];
    $notifTokensKmCheck = [];
    foreach ($notifTokensArr as $notifToken){
        if($notifToken['reminderType'] == "dateOilChange"){
            $notifTokensOil[] = $notifToken['notifToken'];
        }elseif($notifToken['reminderType'] == "dateSTK"){
            $notifTokensSTK[] = $notifToken['notifToken'];
        }else{
            $notifTokensKmCheck[] = $notifToken['notifToken'];
        }
    }

    // Notifying users based on reminder types
    $notifHandler->sendNotif($notifTokensOil,"Vozidlo potřebuje promazat!", "Je čas vyměnit olej ve vašem voze.");
    $notifHandler->sendNotif($notifTokensSTK,"Připravte se na STK!", "Je čas připravit váš vůz na STK.");
    $notifHandler->sendNotif($notifTokensKmCheck,"Vozidlo by potřebovalo prohlédnout!", "Je čas udělat pravidelnou technickou prohlídku vozu.");
