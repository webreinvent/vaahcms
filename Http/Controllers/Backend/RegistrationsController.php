<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Models\Registration;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahCms\Models\TaxonomyBase;
use WebReinvent\VaahCms\Models\User;

class RegistrationsController extends Controller
{
    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-registrations-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $data = [];

            $data['permission'] = [];
            $data['rows'] = config('vaahcms.per_page');

            $data['fillable']['except'] = [
                'uuid',
                'created_by',
                'updated_by',
                'deleted_by',
            ];


            $model = new Registration();
            $fillable = $model->getFillable();
            $data['fillable']['columns'] = array_diff(
                $fillable, $data['fillable']['except']
            );

            foreach ($fillable as $column) {
                $data['empty_item'][$column] = null;
            }

            $custom_fields = Setting::query()->where('category','user_setting')
                ->where('label','custom_fields')->first();

            $data['empty_item']['meta']['custom_fields'] = [];

            if (isset($custom_fields)) {
                foreach ($custom_fields['value'] as $custom_field) {
                    $data['empty_item']['meta']['custom_fields'][$custom_field->slug] = null;
                }
            }

            //---------------------------------------------------

            $data['language_strings'] = [
                "page_title" => trans("vaahcms-registration.registrations_title"),
                "filter_email_verification_pending" => trans("vaahcms-registration.filter_email_verification_pending"),
                "filter_users_email_verification_pending" => trans("vaahcms-registration.filter_users_email_verification_pending"),
                "filter_users_email_verified" =>trans("vaahcms-registration.filter_users_email_verified"),
                "filter_email_verified" => trans("vaahcms-registration.filter_email_verified"),
                "filter_user_created" => trans("vaahcms-registration.filter_user_created"),
                "table_gender_male" => trans("vaahcms-registration.table_gender_male"),
                "table_gender_female" => trans("vaahcms-registration.table_gender_female"),
                "table_gender_others" => trans("vaahcms-registration.table_gender_others"),
            ];
            $data['language_strings']['registration'] = $this->getGeneralStrings();

            //---------------------------------------------------

            $data['actions'] = [];

            $data['country_calling_code'] = vh_get_countries_calling_codes();
            $data['countries'] = vh_get_country_list();
            $data['timezones'] = vh_get_timezones();
            $data['country_code'] = vh_get_country_list();
            $data['registration_statuses'] = TaxonomyBase::getTaxonomyByType('registrations');
            $data['bulk_actions'] = vh_general_bulk_actions();
            $data['name_titles'] = vh_name_titles();
            $data['fields'] = User::getUserSettings();
            $data['custom_fields'] = $custom_fields;

            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getGeneralStrings() :array {
        return [

        ];
    }
    //----------------------------------------------------------
    public function getList(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-registrations-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response= Registration::getList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateList(Request $request): JsonResponse
    {

        $permission_slug = 'can-update-registrations';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Registration::updateList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type): JsonResponse
    {
        $permission_slugs = ['can-update-registrations','can-manage-registrations'];
        $permission_response = Auth::user()->hasPermissions($permission_slugs);

        if(isset($permission_response['success']) && $permission_response['success'] == false) {
            return response()->json($permission_response);
        }

        try {
            $response= Registration::listAction($request, $type);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request): JsonResponse
    {
        $permission_slugs = ['can-update-registrations','can-delete-registrations'];

        $permission_response = Auth::user()->hasPermissions($permission_slugs);

        if(isset($permission_response['success']) && $permission_response['success'] == false) {
            return response()->json($permission_response);
        }

        try {
            $response = Registration::deleteList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createItem(Request $request): JsonResponse
    {
        $permission_slug = 'can-create-registrations';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Registration::createItem($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-registrations';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response =  Registration::getItem($id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request ,$id): JsonResponse
    {
        $permission_slug = 'can-update-registrations';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Registration::updateItem($request, $id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request, $id): JsonResponse
    {
        $permission_slugs = ['can-update-registrations','can-delete-registrations'];

        $permission_response = Auth::user()->hasPermissions($permission_slugs);

        if(isset($permission_response['success']) && $permission_response['success'] == false) {
            return response()->json($permission_response);
        }

        try {
            $response = Registration::deleteItem($request, $id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request, $id, $action): JsonResponse
    {
        $permission_slugs = ['can-update-registrations','can-manage-registrations'];

        $permission_response = Auth::user()->hasPermissions($permission_slugs);

        if(isset($permission_response['success']) && $permission_response['success'] == false) {
            return response()->json($permission_response);
        }

        try {
            $response = Registration::itemAction($request, $id, $action);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function sendVerificationEmail(Request $request,$id): JsonResponse
    {
        try {
            $response = Registration::sendVerificationEmail($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createUser(Request $request,$id): JsonResponse
    {
        $permission_slug = 'can-create-users-from-registrations';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Registration::createUser($request,$id);
        }  catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
