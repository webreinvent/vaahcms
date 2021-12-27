<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use WebReinvent\VaahCms\Entities\Notification;
use WebReinvent\VaahCms\Entities\NotificationContent;
use WebReinvent\VaahCms\Entities\Notified;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Libraries\VaahBackup;
use WebReinvent\VaahCms\Libraries\VaahSetup;
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

        if($request->has('update_available') && $request->update_available){
            self::createBackendNotificationForUpdate($request);
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
            $data = shell_exec('cd '.base_path().' && composer update --ignore-platform-reqs');
            $response['status'] = 'success';
            $response['data'] = $data;
            //$response['messages'][] = 'Action was successful';
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

            //publish assets
            VaahSetup::publishAssets();

            //publish all migrations of vaahcms package
            $provider = "WebReinvent\VaahCms\VaahCmsServiceProvider";
            $response = VaahArtisan::publishMigrations($provider);

            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return $response;
            }

            //publish vaahcms seeds
            $response = VaahArtisan::publishSeeds($provider);
            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return $response;
            }

            $res['status'] = 'success';
            return $res;
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

            $res['status'] = 'success';
            return $res;
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
            VaahArtisan::clearCache();

            $notification = Notification::where('slug','send-update-message')->first();

            Notified::where('vh_notification_id',$notification->id)->forceDelete();

            $response['status'] = "success";
            return $response;
        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }

    }
    //----------------------------------------------------------
    public function createBackendNotificationForUpdate($request)
    {

        $notification = Notification::where('slug','send-update-message')->first();

        if(!$notification){
            $notification = new Notification();
            $notification->slug = 'send-update-message';
            $notification->name = 'Send Update Message';
            $notification->via_backend = '1';
            $notification->save();
        }

        $message = 'A newer version '.$request->remote_version.' of VaahCMS is available.';
        $label = 'Go to Update';
        $link = route('vh.backend').'#/vaah/settings/update';

        if($request->has('manual_update') && $request->manual_update){
            $message = $message . ' This is a major release. You have to do manual upgrade to update VaahCms.';
        }


        $translated = [
            "message" => $message,
            "action" => [
                "label" => $label,
                "link" => $link
            ],
        ];

        $notified = Notified::where('vh_notification_id',$notification->id)
            ->where('via','backend')
            ->where('vh_user_id',Auth::user()->id)->first();

        if(!$notified){
            $notified = new Notified();
            $notified->vh_notification_id = $notification->id;
            $notified->vh_user_id = Auth::user()->id;
            $notified->via = 'backend';
        }

        $notified->meta = $translated;
        $notified->last_attempt_at = null;
        $notified->sent_at = null;
        $notified->read_at = null;
        $notified->marked_delivered = null;

        $notified->save();

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
