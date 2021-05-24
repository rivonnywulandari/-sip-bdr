<?php

namespace App\Helpers;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;


class firebase
{
    public static function updateDeviceId(string $fcm_token, string $device_id)
    {
        try{
            $database = app('firebase.database');
            $updates = [
                'Users/'.$fcm_token.'/device_id' => $device_id
            ];
            $result = $database->getReference()->update($updates);
            return $result->getChild('Users/'.$fcm_token.'/device_id')->getValue();
        }
        catch (\Exception $e) {
            return null; 
        }
    }

    public static function subscribeTopic(string $topic, string $deviceId)
    {
        try{
            $messaging = app('firebase.messaging');
            if(!$topic){
                $topic = "Presensi JSI";
            }

            if($deviceId){
                $messaging->subscribeToTopic($topic, $deviceId);
                return true;
            }
            return false;
        }
        catch (\Exception $e) {
            return false; 
        }
    }

    public static function unSubscribeTopic(string $topic, string $fcm_token)
    {
        try{
            $messaging = app('firebase.messaging');
            $database = app('firebase.database');
            $deviceId = $database->getReference('Users/'.$fcm_token.'/device_id')->getValue();
            if($deviceId){
                $messaging->unsubscribeFromTopic($topic, $deviceId);
                return true;
            }
            return false;
        }
        catch (\Exception $e) {
            return false; 
        }
    }

    public static function unSubscribeAllTopicByDeviceId($deviceId)
    {
        $messaging = app('firebase.messaging');
        $appInstance = $messaging->getAppInstance($deviceId);
        $subscriptions = $appInstance->topicSubscriptions();
        foreach ($subscriptions as $subscription) {
            if($subscription->registrationToken()==$deviceId){
                $messaging->unsubscribeFromTopic($subscription->topic(), $deviceId);
            }
        }
    }

    public static function unSubscribeAllTopic(string $fcm_token)
    {
        try{
            $messaging = app('firebase.messaging');
            $database = app('firebase.database');
            $deviceId = $database->getReference('Users/'.$fcm_token.'/device_id')->getValue();
            if($deviceId){
                //unsubscribe 
                $appInstance = $messaging->getAppInstance($deviceId);
                $subscriptions = $appInstance->topicSubscriptions();
                foreach ($subscriptions as $subscription) {
                    if($subscription->registrationToken()==$deviceId){
                        $messaging->unsubscribeFromTopic($subscription->topic(), $deviceId);
                    }
                }
                return true;
            }
            return false;
        }
        catch (\Exception $e) {
            return false; 
        }
    }

    public static function sendNotificationToUID(string $fcm_token, array $data)
    {
        // UID = fcm_token
        try{
            $messaging = app('firebase.messaging');
            $database = app('firebase.database');

            $newKey = $database->getReference('Users')->push()->getKey();
            $updates = [ 'Users/'.$fcm_token.'/Notification/'.$newKey => $data ];
            $deviceId =  $database->getReference('Users/'.$fcm_token.'/device_id')->getValue();
            if($deviceId){
                $notification = Notification::fromArray($data);
                $message = CloudMessage::withTarget('token', $deviceId)->withNotification($notification);
                $messaging->send($message);
                return true;
            }
            return false;
        }
        catch (\Exception $e) {
            return false; 
        }
    }

    public static function sendNotificationToTopic(string $topic, array $data)
    {
        try{
            $messaging = app('firebase.messaging');
            if(!$topic){
                $topic = "Presensi JSI";
            }
            $notification = Notification::fromArray($data);
            $message = CloudMessage::withTarget('topic', $topic)->withData($data);
            $messaging->send($message);
            return false;
        }
        catch (\Exception $e) {
            return false; 
        }
    }

    public static function sendSubmission($data)
    {
        try{
            $messaging = app('firebase.messaging');
            $database = app('firebase.database');

            $newKey = $database->getReference('Location')->push()->getKey();

            if (auth('api')->user()->student) {
                $receiver_id = auth()->guard('api')->user()->student->lecturer_id;
                $updates = [ 
                    'Location/'.$newKey => [
                        'id' => $data->id,
                        'sender' => $data->student_id,
                        'receiver' => $receiver_id,
                        'submission_status' => $data->submission_status
                    ]
                ];
            } else if (auth('api')->user()->lecturer) {
                $sender_id = auth()->guard('api')->user()->id;
                $updates = [ 
                    'Location/'.$newKey => [
                        'id' => $data->id,
                        'sender' => $sender_id,
                        'receiver' => $data->student_id,
                        'submission_status' => $data->submission_status
                    ]
                ];
            }
        
            $result = $database->getReference()->update($updates);
            return true;
        }
        catch (\Exception $e) {
            return false; 
        }
    }
    
    public static function deleteLocation($locationId)
    {
        $database = app('firebase.database');
        $ref = $database->getReference('Location');
        $data = $ref->orderByChild('id')->equalTo((int)$locationId)->getSnapshot()->getValue();
        if($data){
            $set = array_keys($data)[0];
            $ref->update([$set=>null]);
            return true;
        }   
        return false;
        
    }
}