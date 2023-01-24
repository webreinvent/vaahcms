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

        foreach ($fillable as $column)
        {
            $data['empty_item'][$column] = null;
        }

        $taxonomy_types = TaxonomyType::whereNotNull('is_active')
            ->whereNull('parent_id')->with(['children'])
            ->select('id', 'name', 'slug')->get();

        $data['actions'] = [];
        $data['types'] = $taxonomy_types;

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


}
