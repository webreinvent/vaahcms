<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend\Settings;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Models\Setting;

class UserSettingController extends Controller
{
    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $data['timezones'] = vh_get_timezones();
            $data['country_calling_codes'] = vh_get_countries_calling_codes();

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
            $fields = Setting::query()
                ->where('category','user_setting')
                ->where('label','field')
                ->select('id','key','label','type','value')
                ->get();

            $custom_fields = Setting::query()
                ->where('category','user_setting')
                ->where('label','custom_fields')
                ->select('id','key','label','type','value')
                ->first();

            $response['success'] = true;
            $response['data']['list']['fields'] = $fields;
            $response['data']['list']['custom_fields'] = $custom_fields;
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
    public function storeCustomField(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $inputs = $request->item;

            $rules = array(
                'value.*.name' => 'required',
            );

            $validator = \Validator::make( $inputs, $rules);

            if ($validator->fails()) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $input = $request->item;

            if ($input['id']){
                Setting::query()
                    ->where('id', $input['id'])
                    ->update($input);
            } else {
                $item = new Setting();
                $item->fill($input);
                $item->save();
            }

            $response['success'] = true;
            $response['messages'][] = 'Updated';
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
    public function storeField(Request $request): JsonResponse
    {

        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $input = $request->item;

            Setting::query()->where('id', $input['id'])->update($input);

            $response['success'] = true;
            $response['data']['item'] = $input;
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
