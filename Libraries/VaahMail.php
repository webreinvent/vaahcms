<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Jobs\ProcessMails;
use WebReinvent\VaahCms\Mail\GenericMail;
use WebReinvent\VaahCms\Notifications\TestSmtp;

use Dotenv\Dotenv;

class VaahMail{

    //----------------------------------------------------------
    //----------------------------------------------------------
    /*
     * $to = [
     *          ['email' => 'email@example.com', 'name' => 'name'],
     *          ['email' => 'email@exampl.com', 'name' => 'name 2'],
     *      ]
     */
    public static function dispatch($mail, $to=null, $priority='default')
    {
        if(config('settings.global.laravel_queues'))
        {
            $response = self::addInQueue($mail, $to, $priority);
        } else
        {
            $response = self::send($mail, $to);
        }

        return $response;

    }
    //----------------------------------------------------------
    public static function dispatchToUser($mail, User $user, $priority='default')
    {

        $to = [
            [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ];

        $response = self::dispatch($mail, $to, $priority);

        return $response;

    }
    //----------------------------------------------------------
    public static function addInQueue($mail, $to=null, $priority='default')
    {

        dispatch((new ProcessMails($mail, $to))->onQueue($priority));

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;

    }
    //-------------------------------------------------
    public static function send($mail, $to=null){

        try{
            \Mail::to($to)->send($mail);

            $response['status'] = 'success';
            $response['data'] = [];
            $response['messages'][] = trans('vaahcms-general.action_successful');
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return $response;

    }
    //----------------------------------------------------------
    public static function dispatchGenericMail($content, User $user, $priority='default')
    {
        $to = [
            [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ];

        $mail = new GenericMail($content);

        $response = self::dispatch($mail, $to, $priority);

        return $response;

    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------

}
