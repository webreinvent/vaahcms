<?php namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Entities\Taxonomy;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Models\Registration;


class RegistrationsController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------

    public function getAssets(Request $request)
    {

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

        foreach ($fillable as $column)
        {
            $data['empty_item'][$column] = null;
        }

        $data['actions'] = [];

//      field copied from Http/Registration controller 's assets methods
        $data['country_calling_code'] = vh_get_country_list();
        $data['countries'] = vh_get_country_list();
        $data['timezones'] = vh_get_timezones();
        $data['country_code'] = vh_get_country_list();
        $data['registration_statuses'] = Taxonomy::getTaxonomyByType('registrations');
        $data['bulk_actions'] = vh_general_bulk_actions();
        $data['name_titles'] = vh_name_titles();
        $data['fields'] = User::getUserSettings();
        $data['custom_fields'] = Setting::where('category','user_setting')
            ->where('label','custom_fields')->first();
        //      field copied from Http/Registration controller 's assets methods


        $response['success'] = true;
        $response['data'] = $data;

        return $response;
    }

    //----------------------------------------------------------
    public function getList(Request $request)
    {
        return Registration::getList($request);
    }
    //----------------------------------------------------------
    public function updateList(Request $request)
    {
        return Registration::updateList($request);
    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type)
    {
        return Registration::listAction($request, $type);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request)
    {
        return Registration::deleteList($request);
    }
    //----------------------------------------------------------
    public function createItem(Request $request)
    {
        return Registration::createItem($request);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        return Registration::getItem($id);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request,$id)
    {
        return Registration::updateItem($request,$id);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request,$id)
    {
        return Registration::deleteItem($request,$id);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request,$id,$action)
    {
        return Registration::itemAction($request,$id,$action);
    }
    //----------------------------------------------------------


}
