<?php namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Models\Taxonomy;
use WebReinvent\VaahCms\Models\TaxonomyType;


class TaxonomiesController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------

    public function getAssets(Request $request)
    {
        if (!Auth::user()->hasPermission('has-access-of-taxonomies-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $data = [];

        $data['permission'] = [];
        $data['rows'] = config('vaahcms.per_page');

        $data['fillable']['except'] = [
            'uuid',
            'created_by',
            'updated_by',
            'deleted_by',
        ];

        $model = new Taxonomy();
        $fillable = $model->getFillable();
        $data['fillable']['columns'] = array_diff(
            $fillable, $data['fillable']['except']
        );

        foreach ($fillable as $column) {
            $data['empty_item'][$column] = null;
        }

        $taxonomy_types = TaxonomyType::query()
            ->whereNotNull('is_active')
            ->whereNull('parent_id')
            ->select('id', 'uuid as key', 'name as label', 'slug as data')
            ->with(['children'])
            ->get();

        $data['actions'] = [];
        $data['types'] = $taxonomy_types->toArray();

        $response['success'] = true;
        $response['data'] = $data;

        return $response;
    }

    //----------------------------------------------------------
    public function getList(Request $request)
    {
        return Taxonomy::getList($request);
    }
    //----------------------------------------------------------
    public function updateList(Request $request)
    {
        return Taxonomy::updateList($request);
    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type)
    {
        return Taxonomy::listAction($request, $type);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request)
    {
        return Taxonomy::deleteList($request);
    }
    //----------------------------------------------------------
    public function createItem(Request $request)
    {
        return Taxonomy::createItem($request);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        return Taxonomy::getItem($id);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request,$id)
    {
        return Taxonomy::updateItem($request,$id);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request,$id)
    {
        return Taxonomy::deleteItem($request,$id);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request,$id,$action)
    {
        return Taxonomy::itemAction($request,$id,$action);
    }
    //----------------------------------------------------------
    public function createTaxonomyType(Request $request)
    {

        if (!Auth::user()->hasPermission('can-manage-taxonomy-type')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        if (!$request->has('name') || !$request->name) {
            $response['success'] = false;
            $response['errors'][] = 'The name field is required.';
            return $response;
        }

        $item = TaxonomyType::where('name',$request->name)
            ->withTrashed()->first();

        if($item)
        {
            $response['success'] = false;
            $response['errors'][] = "This name is already exist.";
            return $response;
        }

        $add = new TaxonomyType();
        $add->fill($request->all());
        $add->slug = Str::slug($request->name);
        $add->is_active = true;
        $add->save();

        $response['success'] = true;
        $response['messages'][] = 'Successfully Added.';
        return $response;
    }
    //----------------------------------------------------------
    public function deleteTaxonomyType(Request $request)
    {
        if (!Auth::user()->hasPermission('can-manage-taxonomy-type')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $item = TaxonomyType::where('id',$request->id)->with(['childrens'])
            ->withTrashed()->first();

        if(count($item->childrens) > 0){
            self::deletechildrens($item->childrens);
        }

        $item->forceDelete();

        $response['success'] = true;
        $response['messages'][] = 'Successfully Deleted.';
        return $response;
    }
    //----------------------------------------------------------
    public function deletechildrens($types)
    {
        foreach ($types as $type){
            if(count($type->childrens) > 0){
                self::deletechildrens($type->childrens);
            }

            $type->forceDelete();
        }

    }
    //----------------------------------------------------------
    public function updateTaxonomyType(Request $request)
    {

        if (!Auth::user()->hasPermission('can-manage-taxonomy-type')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        if (!$request->newName) {
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
        return $response;

    }
    //----------------------------------------------------------
    public function updateTaxonomyTypePosition(Request $request)
    {

        if (!Auth::user()->hasPermission('can-manage-taxonomy-type')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $parent_id = null;

        if ($request->parent_id && $request->parent_id != 0) {

            $parent_id = $request->parent_id;
        }

        $item = TaxonomyType::where('id',$request->id)->first();

        $item->parent_id = $parent_id;
        $item->save();

        $response['status']       = 'success';
        $response['messages'][]   = 'Updated Successfully.';
        return $response;

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


}
