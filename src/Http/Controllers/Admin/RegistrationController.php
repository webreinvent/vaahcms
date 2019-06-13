<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Entities\Registration;

class RegistrationController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_admin_theme();
    }

    //----------------------------------------------------------
    public function index()
    {
        return view($this->theme.'.pages.registrations');
    }
    //----------------------------------------------------------
    public function assets(Request $request)
    {

        $reg = new Registration();
        $data['columns'] = $reg->getFormColumns(true);
        $data['debug'] = config('vaahcms.debug');
        $data['country_calling_code'] = vh_get_country_list();
        $data['country'] = vh_get_country_list();
        $data['country_code'] = vh_get_country_list();
        $data['registration_statuses'] = vh_registration_statuses();
        $data['name_titles'] = vh_name_titles();


        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function store(Request $request)
    {
        $response = Registration::store($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getDetails(Request $request, $id)
    {

        $reg = Registration::find($id);

        $response['status'] = 'success';
        $response['data'] = $reg->recordForFormElement();

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {


        if($request->has("sort_by") && !is_null($request->sort_by))
        {
            $list = Registration::orderBy($request->sort_by, $request->sort_type);
        } else
        {
            $list = Registration::orderBy('created_at', 'DESC');
        }

        if($request->has("q"))
        {
            $list->where(function ($q) use ($request){
                $q->where('first_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('email', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('id', '=', $request->q)
                    ->orWhere('last_name', 'LIKE', '%'.$request->q.'%');
            });
        }



        $data['list'] = $list->paginate(config('vaahcms.per_page'));

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------


}
