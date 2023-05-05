<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use WebReinvent\VaahCms\Libraries\VaahSetup;
use WebReinvent\VaahCms\Models\Notification;
use WebReinvent\VaahCms\Models\Notified;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahExtend\Libraries\VaahArtisan;

class UpdateController extends Controller
{
    public $process;

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function storeUpdate(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
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

            foreach ($settings as $setting) {
                $stored_settings = Setting::query()
                    ->where('category', $setting['category'])
                    ->where('key', $setting['key'])
                    ->first();

                if (!$stored_settings) {
                    $stored_settings = new Setting();
                }

                $stored_settings->fill($setting);
                $stored_settings->save();
            }

            if ($request->has('update_available') && $request->update_available) {
                self::createBackendNotificationForUpdate($request);
            }

            $response['success'] = true;
            $response['data'][] = '';
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function upgrade(): JsonResponse
    {
        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = $this->runCommand("composer", "update");
        } catch(\Exception $e) {
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function publish()
    {

        if(!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            //publish assets
            VaahSetup::publishAssets();

            //publish vaahcms configurations
            VaahSetup::publishConfig();

            //publish all migrations of vaahcms package
            $provider = "WebReinvent\VaahCms\VaahCmsServiceProvider";
            $response = VaahArtisan::publishMigrations($provider);

            if (isset($response['success']) && !$response['success']) {
                return $response;
            }

            //publish vaahcms seeds
            $response = VaahArtisan::publishSeeds($provider);
            if (isset($response['success']) && !$response['success']) {
                return $response;
            }

            $response['success'] = true;
        } catch (\Exception $e) {
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function runMigrations(): JsonResponse
    {

        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try{
            self::setVaahCmsVersionInEnv();

            //run migration
            $response = VaahArtisan::migrate();
            if (isset($response['success']) && !$response['success']) {
                return $response;
            }

            //run vaahcms seeds
            $seed_class = "WebReinvent\VaahCms\Database\Seeders\VaahCmsTableSeeder";
            $response = VaahArtisan::seed('db:seed', $seed_class);
            if (isset($response['success']) && !$response['success']) {
                return response()->json($response);
            }

            $response['success'] = true;
        } catch (\Exception $e) {
            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function clearCache(): JsonResponse
    {

        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            VaahArtisan::clearCache();

            $notification = Notification::where('slug','send-update-message')->first();

            Notified::query()->where('vh_notification_id',$notification->id)->forceDelete();

            $response['success'] = true;
        } catch (\Exception $e) {

            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createBackendNotificationForUpdate($request)
    {
        try {
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
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }

            return response()->json($response);
        }
    }
    //----------------------------------------------------------
    public static function setVaahCmsVersionInEnv()
    {

        try {
            $reflector = new \ReflectionClass(\WebReinvent\VaahCms\VaahCmsServiceProvider::class);

            $ref_path = str_replace("VaahCmsServiceProvider.php","",$reflector->getFileName());

            $path =$ref_path .'composer.json';

            $config_data = json_decode(file_get_contents($path), true);

            $env_list = VaahSetup::getEnvFileVariables(null, 'list');

            $env_config_exist = false;

            foreach ($env_list as $key => $item){
                if($item['key'] === 'VAAHCMS_VERSION'){
                    $env_config_exist = true;
                    $env_list[$key]['value'] = $config_data['version'];
                }
            }

            if(!$env_config_exist){
                $env_list[] = [
                    'key' => 'VAAHCMS_VERSION',
                    'value' => $config_data['version']
                ];
            }

            $request = new Request($env_list);

            VaahSetup::generateEnvFile($request, 'list');

        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }

            return response()->json($response);
        }
    }
    //----------------------------------------------------------
    /*
     * $executor like "composer", "php", "npm" etc
     * $command lik "install", "upgrade", "update"
     */
    public function runCommand($executor, $command): JsonResponse
    {

        try {
            $buffer = null;
            $output = null;

            $this->process = new Process([$executor, $command]);

            if($executor == 'composer')
            {
                $this->process->setEnv(['COMPOSER_HOME' => base_path('vendor/bin/composer')]);
                $this->process->setWorkingDirectory(base_path('/'));
            }
            $this->process->run();

            if (!$this->process->isSuccessful()) {
                $response['success']  = false;
                $output .= $this->process->getErrorOutput();
            } else{
                $response['success']  = true;
                $output .= $this->process->getOutput();
            }


            $response['data']['buffer'] = $buffer;
            $response['data']['output'] = $output;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------


}
