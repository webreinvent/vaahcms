<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Taxonomy;

class TaxonomiesController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {

    }
    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        $data = [];


        $country_exist = Taxonomy::where('type','Countries')
            ->whereNotNull('is_active')->exists();

        if(!$country_exist){
            $country_list = \VaahCountry::getListWithSlug();

            foreach ($country_list as $item){
                $add = new Taxonomy();
                $add->type = "Countries";
                $add->name = $item['name'];
                $add->slug = $item['slug'];
                $add->is_active = '1';
                $add->save();
            }


        }

        $data['permission'] = [];

        $data['bulk_actions'] = vh_general_bulk_actions();

        $data['types'] = [
            'Cities',
            'Countries',
            'Currencies',
            'Industries',
            'Lead Sources',
            'Lead Statuses',
            'Thread Label',
            'Company Sources',
            'Contact Sources'
        ];

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    public function postCreate(Request $request, $sub_domain)
    {
        $response = Taxonomy::createItem($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request, $sub_domain)
    {
        $response = Taxonomy::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $sub_domain, $id)
    {
        $response = Taxonomy::getItem($id);
        return response()->json($response);
    }

    //----------------------------------------------------------
    public function postStore(Request $request, $sub_domain,$id)
    {
        $response = Taxonomy::postStore($request,$id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $sub_domain, $action)
    {
        $rules = array(
            'inputs' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = [];

        $response['status'] = 'success';

        $inputs = $request->all();

        switch ($action)
        {

            //------------------------------------
            case 'bulk-change-status':

                $response = Taxonomy::bulkStatusChange($request);

                break;
            //------------------------------------
            case 'bulk-trash':

                $response = Taxonomy::bulkTrash($request);

                break;
            //------------------------------------
            case 'bulk-restore':

                $response = Taxonomy::bulkRestore($request);

                break;

            //------------------------------------
            case 'bulk-delete':

                $response = Taxonomy::bulkDelete($request);

                break;
            //------------------------------------
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getCountries(Request $request, $sub_domain, $query=null)
    {

        $list = Taxonomy::where(function($q) use ($query){
            $q->where('name', 'LIKE', '%'.$query.'%')
                ->orWhere('slug', 'LIKE', '%'.$query.'%');
        })->where('type','Countries')
            ->whereNotNull('is_active')
            ->take(10)
            ->orderBy('created_at', 'desc')
            ->select('id','name','slug')->get();

        return $list;

    }
    //----------------------------------------------------------
    public function getCountryById(Request $request, $sub_domain, $id)
    {
        return Taxonomy::find($id);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------



}
