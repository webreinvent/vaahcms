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
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Libraries\VaahBackup;
use WebReinvent\VaahCms\Libraries\VaahHelper;
use WebReinvent\VaahCms\Libraries\VaahSetup;


class UserSettingController extends Controller
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

        $data['timezones'] = vh_get_timezones();
        $data['country_calling_codes'] = vh_get_countries_calling_codes();

        $response['status'] = 'success';
        $response['data'] = $data;

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

        $fields = Setting::where('category','user_setting')
            ->where('label','field')
            ->select('id','key','label','type','value')->get();

        $custom_fields = Setting::where('category','user_setting')
            ->where('label','custom_field')
            ->select('id','key','label','type','value')
            ->orderBy('meta','asc')->get();

        $response['status'] = 'success';
        $response['data']['list']['fields'] = $fields;
        $response['data']['list']['custom_fields'] = $custom_fields;

        return response()->json($response);

    }

    //----------------------------------------------------------
    public function storeCustomField(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $inputs = $request->item;


        $rules = array(
            '*.key' => 'required',
        );

        $validator = \Validator::make( $inputs, $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $stored_groups = Setting::where('category','user_setting')
            ->where('label','custom_field')->get()->pluck('key','id')->toArray();

        $input_groups = collect($inputs)->pluck('key')->toArray();

        $groups_to_delete = array_diff($stored_groups, $input_groups);



        if(count($groups_to_delete) > 0)
        {
            $groups_to_delete = array_flip($groups_to_delete);

//            dd($stored_groups,$input_groups,$groups_to_delete);

            foreach ($groups_to_delete as $id)
            {
                Setting::where('id', $id)->forceDelete();
            }

        }

        foreach ($inputs as $key => $input){
            $input['meta'] = $key;

            if($input['id']){
                $item =  Setting::where('id',$input['id'])->first();
            }else{
                $item =  new Setting();
            }

            $item->fill($input);

            $item->save();
        }

        $response['status'] = 'success';
        $response['messages'][] = 'Updated';

        return response()->json($response);

    }

    //----------------------------------------------------------
    public function storeField(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $input = $request->item;

        Setting::where('id',$input['id'])->update($input);

        $response['status'] = 'success';
        $response['data']['item'] = $input;

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
