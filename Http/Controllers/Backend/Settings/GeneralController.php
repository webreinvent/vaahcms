<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Language;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Libraries\VaahBackup;
use WebReinvent\VaahCms\Models\Role;


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
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }
        $role_data = [];
        foreach (Role::getActiveRoles() as $key => $value){
            $role_data[$key] = $value->name;
        }

        $vh_file_types_data = [];
        foreach (vh_file_types() as $key => $value){
            $vh_file_types_data[$key] = $value['slug'];
        }

        $response['success'] = true;
        $response['data']['base_url'] = url('/');
        $response['data']['roles'] = $role_data;
        $response['data']['file_types'] = $vh_file_types_data;
        $response['data']['vh_meta_attributes'] = vh_meta_attributes();
        $response['data']['languages'] = Language::select('name', 'locale_code_iso_639')->get();

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $data = [];

        $data['list'] = Setting::getGlobalSettings($request);
        $data['links'] = Setting::getGlobalLinks($request);
        $data['scripts'] = Setting::getGlobalScripts($request);
        $data['meta_tags'] = Setting::getGlobalMetaTags($request);

        $response['success'] = true;
        $response['data'] = $data;

        return response()->json($response);

    }

    //----------------------------------------------------------
    public function storeSiteSettings(Request $request)
    {


        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['success'] = false;
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
                $setting->key = $key;
                $setting->value = $value;
                $setting->category = 'global';
                $setting->save();
            }
            else{
                Setting::where('category', 'global')
                    ->where('key', $key)
                    ->update(['value' => $value]);
            }
        }
        $response['success'] = true;
        $response['data'][] = '';
        $response['messages'][] = 'Settings successful saved';

        return $response;

    }
    //----------------------------------------------------------
    public function storeLinks(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $rules = array(
            'links' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];

        $stored_link = Setting::where('category', 'global')
            ->where('type', 'link')
            ->get()->pluck('id')->toArray();

        $input_links = collect($request->links)->pluck('id')->toArray();

        $links_to_delete = array_diff($stored_link, $input_links);

        if(count($links_to_delete)){
            Setting::whereIn('id',$links_to_delete)->delete();
        }

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

        $response['success'] = true;
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
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $rules = array(
            'tags' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
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

        $response['success'] = true;
        $response['messages'][] = 'Saved';
        $response['data'] = $data;
        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function deleteMetaTags(Request $request,)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $data = Setting::where('category', 'global')
                ->where('type', 'meta_tags')
                ->where('id',$request->id)->forceDelete();

        $response['success'] = true;
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}