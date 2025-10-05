<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Libraries\VaahHelper;
use WebReinvent\VaahCms\Models\Module;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahCms\Models\Theme;
use WebReinvent\VaahCms\Models\User;

class PublicController extends Controller
{
    // ----------------------------------------------------------

    // ----------------------------------------------------------
    public function disableMfa(Request $request, $token)
    {

        $user = User::first();

        if ($user) {
            if ($user->api_token && $user->api_token == $token) {

                $mfa_status_setting = Setting::where('key', 'mfa_status')->first();
                if ($mfa_status_setting) {
                    $mfa_status_setting->value = 'disable';
                    $mfa_status_setting->save();
                }

                $mfa_methods_setting = Setting::where('key', 'mfa_methods')->first();
                if ($mfa_methods_setting) {
                    $mfa_methods_setting->value = ['email-otp-verification'];
                    $mfa_methods_setting->type = 'json';
                    $mfa_methods_setting->save();
                }

                // clear cache
                VaahHelper::clearCache();

                $response = [];
                $response['success'] = true;
                $response['message'][] = 'MFA disabled successfully.';

                return $response;

            }

            $response['success'] = false;
            $response['errors'][] = 'Api Token not matched.';

            return $response;

        }

        $response['success'] = false;
        $response['errors'][] = 'User not found.';

        return $response;

    }

    // ----------------------------------------------------------
    public function publishAssets(Request $request, $slug)
    {
        try {

            $module = Module::slug($slug)->first();

            if (! $module) {

                $theme = Theme::slug($slug)->first();

                if (! $theme) {
                    $response['success'] = false;
                    $response['errors'][] = 'Module/Theme not found.';

                    return response()->json($response);
                }

                $message = Theme::copyAssets($theme);

                if (! $message) {
                    $response['success'] = false;
                    $response['errors'][] = 'Something went wrong.';

                    return response()->json($response);
                }

                $theme->is_assets_published = 1;
                $theme->save();
                $response['success'] = true;
                $response['messages'][] = 'Assets published.';

                return response()->json($response);
            }

            $message = Module::copyAssets($module);

            if (! $message) {
                $response['success'] = false;
                $response['errors'][] = 'Something went wrong.';

                return response()->json($response);
            }

            $module->is_assets_published = 1;
            $module->save();
            $response['success'] = true;
            $response['messages'][] = 'Assets published.';
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);

    }
    // ----------------------------------------------------------

}
