<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use WebReinvent\VaahCms\Jobs\ProcessMails;
use WebReinvent\VaahCms\Mail\GenericMail;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahCms\Notifications\TestSmtp;

use Dotenv\Dotenv;

class VaahMail{


    //----------------------------------------------------------
    public static function getFromName($name)
    {
        if(!isset($name))
        {
            $name = env("MAIL_FROM_NAME");

            if(!isset($name))
            {
                $name = env("APP_NAME");
            }
        }

        return $name;
    }
    //----------------------------------------------------------
    public static function getFromEmail($email)
    {
        if(!isset($email))
        {
            $email = env("MAIL_FROM_ADDRESS");

            if(!isset($email))
            {
                $email = "noreply@".request()->getHost();
            }

        }
        return $email;
    }
    //----------------------------------------------------------
    /*
     * $to = [
     *          ['email' => 'email@example.com', 'name' => 'name'],
     *          ['email' => 'email@exampl.com', 'name' => 'name 2'],
     *      ]
     */
    public static function dispatchGenericMail($subject, $message, $to=[],
                                               $from_email=null,
                                               $from_name=null,
                                               $cc=[],
                                               $bcc=[],
                                               $priority='default')
    {

        $from_email = self::getFromEmail($from_email);
        $from_name = self::getFromEmail($from_name);


        $mail = new GenericMail($subject, $message, $from_email, $from_name);


        if(config('settings.global.laravel_queues'))
        {

            dispatch((new ProcessMails($mail, $to, $cc, $bcc))
                ->onQueue($priority));

            $response['success'] = true;
            $response['data'] = [];
            $response['messages'][] = trans('vaahcms-general.action_successful');

            return $response;

        } else
        {
            $response = self::send($mail, $to, $cc, $bcc);
        }

        return $response;

    }
    //----------------------------------------------------------
    /*
     * $to = [
     *          ['email' => 'email@example.com', 'name' => 'name'],
     *          ['email' => 'email@exampl.com', 'name' => 'name 2'],
     *      ]
     */
    public static function dispatch(Mailable $mail, $to=[],
                                           $cc=[],
                                           $bcc=[],
                                           $priority='default')
    {
        if(config('settings.global.laravel_queues'))
        {
            $response = self::addInQueue($mail, $to, $cc, $bcc, $priority);
        } else
        {
            $response = self::send($mail, $to, $cc, $bcc);
        }

        return $response;

    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    public static function dispatchToUser(Mailable $mail, User $user, $cc=[], $bcc=[], $priority='default')
    {

        $to = [
            [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ];

        if(config('settings.global.laravel_queues')) {
            $response = self::dispatch($mail, $to, $cc, $bcc, $priority);
        } else{
            $response = self::send($mail, $to, $cc, $bcc);
        }

        return $response;

    }
    //----------------------------------------------------------
    public static function addInQueue(Mailable $mail, $to=[], $cc=[], $bcc=[], $priority='default')
    {

        dispatch((new ProcessMails($mail, $to, $cc, $bcc))
            ->onQueue($priority));

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;

    }
    //-------------------------------------------------
    public static function send(Mailable $mail, $to=[], $cc=[], $bcc=[]){

        try{
            \Mail::to($to)
                ->cc($cc)
                ->bcc($bcc)
                ->send($mail);

            $response['success'] = true;
            $response['data'] = [];
            $response['messages'][] = trans('vaahcms-general.action_successful');

        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();

        }

        return $response;

    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------

}
