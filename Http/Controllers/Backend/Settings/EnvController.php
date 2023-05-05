<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use WebReinvent\VaahCms\Libraries\VaahHelper;
use WebReinvent\VaahCms\Libraries\VaahSetup;

class EnvController extends Controller
{
    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        if (!\Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $data['is_installed'] = VaahSetup::isInstalled();
            $data['environments'] = vh_environments();
            $data['timezones'] = vh_get_timezones();
            $data['database_types'] = vh_database_types();
            $data['mail_encryption_types'] = vh_mail_encryption_types();
            $data['mail_sample_settings'] = vh_mail_sample_settings();
            $data['country_calling_codes'] = vh_get_countries_calling_codes();
            $data['app_url'] = url("/");

            $response['success'] = true;
            $response['data'] = $data;
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
    public function getList(Request $request): JsonResponse
    {

        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $data = [];

            $data['env_file'] = VaahSetup::getActiveEnvFileName();
            $data['list'] = VaahSetup::getEnvFileVariables(null, 'list');

            $response['success'] = true;
            $response['data'] = $data;
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
    public function downloadFile(Request $request, $file_name): BinaryFileResponse | string
    {

        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            if(!$file_name || !File::exists(base_path('/'.$file_name))){
                return 'No File Found.';
            }

            $file_path =  base_path('/'.$file_name);
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

        return response()->download($file_path);
    }
    //----------------------------------------------------------
    public function store(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = VaahSetup::generateEnvFile($request, 'list');

            if (isset($response['success']) && $response['success']) {
                VaahHelper::clearCache();
                $response['data']['redirect_url'] = route('vh.backend');
            }
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
