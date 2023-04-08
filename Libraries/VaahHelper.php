<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use WebReinvent\VaahCms\Notifications\TestSmtp;

class VaahHelper{

    //----------------------------------------------------------
    public static function testDBConnection($request)
    {
        $rules = array(
            'db_connection' => 'required',
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
        );

        $messages = [
            'db_connection.required' => "Select database type",
            'db_host.required' => "Enter database host",
            'db_port.required' => "Enter database port",
            'db_database.required' => "Enter database name",
            'db_username.required' => "Enter database username",
        ];

        $validator = \Validator::make( $request->all(), $rules, $messages);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        $inputs = [
            'driver' => $request->db_connection,
            'host' => $request->db_host,
            'port' => $request->db_port,
            'database' => $request->db_database,
            'username' => $request->db_username,
            'password' => $request->db_password
        ];
        config(['database.connections.db_connection_test' => $inputs]);

        try{
            $response['success'] = true;
            $response['data']['inputs'] = $inputs;
            $response['data']['result'] = \DB::connection('db_connection_test')->getPdo();
            $response['messages'][] = 'Successfully connect with Database';
        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
        }


        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }

        return $response;

    }
    //----------------------------------------------------------
    public static function sendTestEmail($request) {
        $rules = array(
            'mail_driver' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
            'test_email_to' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        $inputs = [
            'driver' => $request->mail_driver,
            'host' => $request->mail_host,
            'port' => $request->mail_port,
            'username' => $request->mail_username,
            'password' => $request->mail_password,
            'from' => [
                'address' => $request->mail_from_address,
                'name' => $request->mail_from_name,
            ],
            "sendmail" => "/usr/sbin/sendmail -bs"
        ];

        if($request->mail_encryption != 'none')
        {
            $inputs['encryption'] = $request->mail_encryption;
        }

        $response['data']['inputs'] = $inputs;

        try{

            config(['mail' => $inputs]);

            Notification::route('mail', $request->test_email_to)
                ->notify(new TestSmtp());;

            $response['success'] = true;
            $response['data']['inputs'] = $inputs;
            $response['messages'][] = 'Test email successfully sent';


        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();

        }

        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }

        return $response;
    }

    //----------------------------------------------------------
    public static function generateEnvKey()
    {

        try{
            \Artisan::call('key:generate');
            $response['success'] = true;
            $response['data'] = [];
        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();

        }

        return $response;
    }
    //----------------------------------------------------------
    public static function clearCache()
    {
        try{
            \Artisan::call('cache:clear');
            \Artisan::call('route:clear');
            \Artisan::call('config:clear');
            \Artisan::call('view:clear');
            \Artisan::call('clear-compiled');

            $response['success'] = true;
            $response['data'] = [];
        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();

        }

        return $response;
    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    public static function getVaahCMSJsonFileParams()
    {
        try{
            if(File::exists(base_path('/vaahcms.json'))){
                $vaahcms_params = file_get_contents(base_path('/vaahcms.json'));
                $vaahcms_params = json_decode($vaahcms_params, true);
                $data = $vaahcms_params;
                $response['success'] = true;
                $response['data'] = $data;
                return $response;
            } else{
                $response['success'] = false;
                $response['messages'][] = 'vaahcms.json configuration file is missing';
            }
        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
        }
    }
    //----------------------------------------------------------
    public static function getVaahCMSJsonFileParam($key)
    {
        $params = static::getVaahCMSJsonFileParams();

        if(isset($params['success']) && !$params['success'])
        {
            return null;
        }

        if(!isset($params['data'][$key]))
        {
            return null;
        }

        return $params['data'][$key];
    }
    //----------------------------------------------------------

}
