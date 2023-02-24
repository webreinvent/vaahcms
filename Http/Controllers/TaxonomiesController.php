<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Taxonomy;
use WebReinvent\VaahCms\Entities\TaxonomyType;

class TaxonomiesController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {

    }
    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-taxonomies-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $data = [];


            $countries = Taxonomy::getTaxonomyByType('countries');

            if(count($countries) === 0){
                $country_list = \VaahCountry::getListWithSlug();

                $tax_type = TaxonomyType::getFirstOrCreate('countries');

                foreach ($country_list as $item){
                    $add = new Taxonomy();
                    $add->vh_taxonomy_type_id = $tax_type->id;
                    $add->name = $item['name'];
                    $add->slug = $item['slug'];
                    $add->is_active = '1';
                    $add->save();
                }


            }

            $data['permission'] = [];

            $data['bulk_actions'] = vh_general_bulk_actions();

            $data['types'] = TaxonomyType::whereNotNull('is_active')
                ->whereNull('parent_id')->with(['children'])
                ->select('id', 'name', 'slug')->get();

            $response['status'] = 'success';
            $response['data'] = $data;


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    public function postCreate(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('can-create-taxonomies'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = Taxonomy::createItem($request);


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        try{

            if(!\Auth::user()->hasPermission('has-access-of-taxonomies-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = Taxonomy::getList($request);


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        try{

            if(!\Auth::user()->hasPermission('can-read-taxonomies'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = Taxonomy::getItem($id);


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }
        return response()->json($response);
    }

    //----------------------------------------------------------
    public function postStore(Request $request,$id)
    {
        try{

            if(!\Auth::user()->hasPermission('can-update-taxonomies'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = Taxonomy::postStore($request,$id);


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {
        try{

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

                    if(!\Auth::user()->hasPermission('can-manage-taxonomies') &&
                        !\Auth::user()->hasPermission('can-update-taxonomies'))
                    {
                        $response['status'] = 'failed';
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return $response;
                    }

                    $response = Taxonomy::bulkStatusChange($request);

                    break;
                //------------------------------------
                case 'bulk-trash':

                    if(!\Auth::user()->hasPermission('can-update-taxonomies'))
                    {
                        $response['status'] = 'failed';
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return $response;
                    }

                    $response = Taxonomy::bulkTrash($request);

                    break;
                //------------------------------------
                case 'bulk-restore':

                    if(!\Auth::user()->hasPermission('can-update-taxonomies'))
                    {
                        $response['status'] = 'failed';
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return $response;
                    }

                    $response = Taxonomy::bulkRestore($request);

                    break;

                //------------------------------------
                case 'bulk-delete':

                    if(!\Auth::user()->hasPermission('can-update-taxonomies') ||
                        !\Auth::user()->hasPermission('can-delete-taxonomies'))
                    {
                        $response['status'] = 'failed';
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return $response;
                    }

                    $response = Taxonomy::bulkDelete($request);

                    break;
                //------------------------------------
                //------------------------------------

            }


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }
        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getParents(Request $request,$id, $name=null)
    {
        $list = Taxonomy::where(function($q) use ($name){
            $q->where('name', 'LIKE', '%'.$name.'%')
                ->orWhere('slug', 'LIKE', '%'.$name.'%');
        })->where('vh_taxonomy_type_id', $id)
            ->whereNotNull('is_active')
            ->take(10)
            ->orderBy('created_at', 'desc')
            ->select('id','name','slug')->get();

        return $list;

    }
    //----------------------------------------------------------
    public function getCountryById(Request $request, $id)
    {
        return Taxonomy::find($id);
    }
    //----------------------------------------------------------
    public function createTaxonomyType(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('can-manage-taxonomy-type'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return $response;
            }

            if(!$request->has('name') || !$request->name){
                $response['status'] = 'failed';
                $response['errors'][] = 'The name field is required.';
                return $response;
            }

            $item = TaxonomyType::where('name',$request->name)
                ->withTrashed()->first();

            if($item)
            {
                $response['status'] = 'failed';
                $response['errors'][] = "This name is already exist.";
                return $response;
            }

            $add = new TaxonomyType();
            $add->fill($request->all());
            $add->slug = Str::slug($request->name);
            $add->is_active = true;
            $add->save();

            $response['status'] = 'success';
            $response['messages'][] = 'Successfully Added.';


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;
    }
    //----------------------------------------------------------
    public function deleteTaxonomyType(Request $request)
    {
        try{
            if(!\Auth::user()->hasPermission('can-manage-taxonomy-type'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return $response;
            }

            $item = TaxonomyType::where('id',$request->id)->with(['children'])
                ->withTrashed()->first();

            if(count($item->children) > 0){
                self::deleteChildren($item->children);
            }

            $item->forceDelete();

            $response['status'] = 'success';
            $response['messages'][] = 'Successfully Deleted.';


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }
        return $response;
    }
    //----------------------------------------------------------
    public function deleteChildren($types)
    {
        foreach ($types as $type){
            if(count($type->children) > 0){
                self::deleteChildren($type->children);
            }

            $type->forceDelete();
        }

    }
    //----------------------------------------------------------
    public function updateTaxonomyType(Request $request)
    {
        try{

            if(!\Auth::user()->hasPermission('can-manage-taxonomy-type'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return $response;
            }

            if(!$request->newName){
                $response['status']       = 'failed';
                $response['errors'][]     = 'Name is required.';
                return $response;
            }


            $name_exist = TaxonomyType::where('id','!=',$request->id)
                ->where('name',$request->newName)->first();

            if($name_exist){
                $response['status']       = 'failed';
                $response['errors'][]     = 'Name already exist.';
                return $response;
            }


            $slug_exist = TaxonomyType::where('id','!=',$request->id)
                ->where('slug',Str::slug($request->newName))->first();

            if($slug_exist){
                $response['status']       = 'failed';
                $response['errors'][]     = 'Slug already exist.';
                return $response;
            }

            $list = TaxonomyType::where('id',$request->id)->first();

            $list->name = $request->newName;
            $list->slug = Str::slug($request->newName);
            $list->save();

            $response['status']       = 'success';
            $response['messages'][]   = 'Updated Successfully.';


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }
        return $response;

    }
    //----------------------------------------------------------
    public function updateTaxonomyTypePosition(Request $request)
    {
        try{

            if(!\Auth::user()->hasPermission('can-manage-taxonomy-type'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return $response;
            }

            $parent_id = null;

            if($request->parent_id && $request->parent_id != 0){

                $parent_id = $request->parent_id;
            }

            $item = TaxonomyType::where('id',$request->id)->first();

            $item->parent_id = $parent_id;
            $item->save();

            $response['status']       = 'success';
            $response['messages'][]   = 'Updated Successfully.';


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }
        return $response;

    }
    //----------------------------------------------------------
    //----------------------------------------------------------



}
