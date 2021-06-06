<?php


namespace App\Service;


class NotificationHandler
{
    private $dataHandler;

    public function __construct(DataHandler $dataHandler)
    {
        $this->dataHandler = $dataHandler;
    }

    // Sends API request for notification
    public function sendNotif($notifTokensArr, $title, $message){
        // Creating request
        $request = [
            "app_id" => "98017a30-8fe9-4630-9ae9-aa75523b8d58",
            "include_player_ids" => $notifTokensArr, // Gets user notification token by userID
            "contents" => ["en" => $message],
            "headings" => ["en" => $title],
        ];
        $jsonRequest = json_encode($request);

        // Sending request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonRequest);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}