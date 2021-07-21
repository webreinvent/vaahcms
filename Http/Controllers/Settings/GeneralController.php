<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Language;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Libraries\VaahBackup;


class GeneralController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response['status'] = 'success';
        $response['data']['base_url'] = url('/');
        $response['data']['roles'] = Role::getActiveRoles();
        $response['data']['file_types'] = vh_file_types();
        $response['data']['vh_meta_attributes'] = vh_meta_attributes();
        $response['data']['languages'] = Language::select('name', 'locale_code_iso_639')->get();

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $data = [];

        $data['list'] = Setting::getGlobalSettings($request);
        $data['links'] = Setting::getGlobalLinks($request);
        $data['scripts'] = Setting::getGlobalScripts($request);
        $data['meta_tags'] = Setting::getGlobalMetaTags($request);

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }

    //----------------------------------------------------------
    public function storeSiteSettings(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        foreach ($request->list as $key => $value){
            $setting = Setting::where('category', 'global')
                ->where('key', $key)
                ->first();
            if(!$setting)
            {
                $setting = new Setting();
            }
            $setting->key = $key;
            $setting->value = $value;
            $setting->category = 'global';
            $setting->save();
        }

        $response['status'] = 'success';
        $response['data'][] = '';
        $response['messages'][] = 'Settings successful saved';

        return $response;

    }
    //----------------------------------------------------------
    public function storeLinks(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $rules = array(
            'links' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];

        foreach ($request->links as $link)
        {

            $key = 'link_'.Str::slug($link['label'], '_');

            $setting = Setting::where('category', 'global')
                ->where('type', 'link')
                ->where('key', $key)
                ->first();

            if(!$setting)
            {
                $setting = new Setting();
            }
            $setting->fill($link);
            $setting->key = $key;
            $setting->category = 'global';
            $setting->type = 'link';
            $setting->save();
        }

        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data'] = $data;
        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function storeMetaTags(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $rules = array(
            'tags' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];

        foreach ($request->tags as $tag)
        {

            $setting = Setting::where('category', 'global')
                ->where('type', 'meta_tags')
                ->where('key', $tag['key'])
                ->first();

            if(!$setting)
            {
                $setting = new Setting();
            }
            $setting->fill($tag);
            $setting->category = 'global';
            $setting->type = 'meta_tags';
            $setting->save();
        }

        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data'] = $data;
        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
