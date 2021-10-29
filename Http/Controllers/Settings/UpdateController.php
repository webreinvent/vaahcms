<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Libraries\VaahBackup;
use WebReinvent\VaahExtend\Libraries\VaahArtisan;


class UpdateController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function storeUpdate(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $settings = [
            [
                "category"=>'global',
                "key"=> 'update_checked_at',
                "value"=> \Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                "category"=>'global',
                "key"=> 'is_update_available',
                "value"=> $request->update_available,
            ],
            [
                "category"=>'global',
                "key"=> 'latest_remote_version',
                "value"=> $request->remote_version,
            ],
        ];

        foreach ($settings as $setting)
        {
            $stored_settings = Setting::where('category', $setting['category'])
            ->where('key', $setting['key'])
            ->first();

            if(!$stored_settings)
            {
                $stored_settings = new Setting();
            }

            $stored_settings->fill($setting);
            $stored_settings->save();
        }



        $response['status'] = 'success';
        $response['data'][] = '';
        return $response;


    }
    //----------------------------------------------------------
    public function upgrade()
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try{
            $data = shell_exec('cd '.base_path().' && composer update');
            $response['status'] = 'success';
            $response['data'] = $data;
            $response['messages'][] = 'Action was successful';
            return $response;
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }

    }
    //----------------------------------------------------------
    public function publish()
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try{
            $response = VaahArtisan::publish("WebReinvent\VaahCms\VaahCmsServiceProvider");
            return $response;
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }

    }
    //----------------------------------------------------------
    public function runMigrations()
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try{
            $provider = "WebReinvent\VaahCms\VaahCmsServiceProvider";

            //run migration
            $response = VaahArtisan::migrate();
            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return $response;
            }

            //run vaahcms seeds
            $seed_class = "WebReinvent\VaahCms\Database\Seeders\VaahCmsTableSeeder";
            $response = VaahArtisan::seed('db:seed', $seed_class);
            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return $response;
            }

            //publish laravel mail and notifications
            VaahArtisan::publish(null, 'laravel-mail');
            VaahArtisan::publish(null, 'laravel-notifications');

            $response['status'] = 'success';
            $response['messages'][] = 'Action was successful';
            return $response;
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }

    }
    //----------------------------------------------------------
    public function clearCache()
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try{
            $response = VaahArtisan::clearCache();
            $response['messages'][] = "Cache Successfully Removed";
            return $response;
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
