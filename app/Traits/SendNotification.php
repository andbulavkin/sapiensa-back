<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\Post;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;


trait SendNotification
{



    public function sendPush($tokens, $options = [], $data)
    {

        $title = env('APP_NAME');

        // dd($data);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        // $notificationBuilder = new PayloadNotificationBuilder('my title');
        // $notificationBuilder->setBody('Hello world')
        //     ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();

        // $appName = config('app.name');
        $appName=env('APP_NAME');

        if ($data !== null) {
            $dataBuilder = new PayloadDataBuilder();
            // dd($data);
            foreach($data as $row) {
                $dataBuilder->addData($row);
            }

            $data = $dataBuilder->build();
        }


        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($options['body'])->setSound('default');

        $notification = $notificationBuilder->build();
        $downstreamResponse = FCM::sendTo($tokens, null, $notification, $data);

        // dd($downstreamResponse);

        return $downstreamResponse->numberSuccess();

    }

    public function saveNotification($user_id,$to_user_id,$post_id,$message,$type){

        
        if(empty($user_id == $to_user_id)){

            Notification::create([
                'user_id' => $user_id,
                'to_user_id' => $to_user_id,
                'post_id' => (!empty($post_id)) ? $post_id : null,
                'message' => $message,
                'type' => $type
            ]);
        }
 
    }

}
