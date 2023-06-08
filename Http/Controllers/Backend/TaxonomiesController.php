<?php namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
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
    public function getAssets(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('has-access-of-taxonomies-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
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

            $model = new Taxonomy();
            $fillable = $model->getFillable();
            $data['fillable']['columns'] = array_diff(
                $fillable, $data['fillable']['except']
            );

            foreach ($fillable as $column) {
                if ($column === 'is_active') {
                    $data['empty_item'][$column] = 0;
                    continue;
                }

                $data['empty_item'][$column] = null;
            }

            $taxonomy_types = TaxonomyType::query()
                ->whereNotNull('is_active')
                ->whereNull('parent_id')
                ->select('id', 'id as key', 'name as label', 'slug as data')
                ->with(['children'])
                ->get();

            $data['actions'] = [];
            $data['types'] = $taxonomy_types->toArray();

            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('has-access-of-taxonomies-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Taxonomy::getList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateList(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-update-taxonomies') ||
            !Auth::user()->hasPermission('can-manage-taxonomies')
        ) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Taxonomy::updateList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-update-taxonomies') ||
            !Auth::user()->hasPermission('can-manage-taxonomies')
        ) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Taxonomy::listAction($request, $type);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-delete-taxonomies')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Taxonomy::deleteList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createItem(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-create-taxonomies')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Taxonomy::createItem($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-read-taxonomies')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Taxonomy::getItem($id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getListByTypeId(Request $request, $id): JsonResponse
    {
        $response = [];

        try {
            $list = Taxonomy::where('vh_taxonomy_type_id',$id)
                ->select('id','name','slug','vh_taxonomy_type_id')->get();

            $response['success'] = true;
            $response['data'] = $list;
        } catch (\Exception $e) {
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request, $id): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-update-taxonomies')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Taxonomy::updateItem($request, $id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request, $id): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-delete-taxonomies')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Taxonomy::deleteItem($request, $id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request, $id, $action): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-update-taxonomies') ||
            !Auth::user()->hasPermission('can-manage-taxonomies')
        ) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Taxonomy::itemAction($request, $id, $action);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createTaxonomyType(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-manage-taxonomy-type')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            if (!$request->has('name') || !$request->name) {
                $response['success'] = false;
                $response['errors'][] = 'The name field is required.';
                return response()->json($response);
            }

            $item = TaxonomyType::withTrashed()
                ->where('name',$request->name)
                ->first();

            if ($item) {
                $response['success'] = false;
                $response['errors'][] = "This name is already exist.";
                return response()->json($response);
            }

            $add = new TaxonomyType();
            $add->fill($request->all());
            $add->slug = Str::slug($request->name);
            $add->is_active = true;
            $add->save();

            $response['success'] = true;
            $response['messages'][] = 'Successfully Added.';
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteTaxonomyType(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-manage-taxonomy-type')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $item = TaxonomyType::query()
                ->where('id',$request->id)
                ->with(['childrens'])
                ->withTrashed()
                ->first();

            if(count($item->childrens) > 0){
                self::deletechildrens($item->childrens);
            }

            $item->forceDelete();

            $response['success'] = true;
            $response['messages'][] = 'Successfully Deleted.';
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deletechildrens($types)
    {
        foreach ($types as $type) {
            if (count($type->childrens) > 0) {
                self::deletechildrens($type->childrens);
            }

            $type->forceDelete();
        }
    }
    //----------------------------------------------------------
    public function updateTaxonomyType(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-manage-taxonomy-type')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            if (!$request->newName) {
                $response['success']  = false;
                $response['errors'][] = 'Name is required.';
                return response()->json($response);
            }

            $name_exist = TaxonomyType::query()
                ->where('id','!=',$request->id)
                ->where('name',$request->newName)->first();

            if ($name_exist) {
                $response['success']  = false;
                $response['errors'][] = 'Name already exist.';
                return response()->json($response);
            }


            $slug_exist = TaxonomyType::query()
                ->where('id','!=',$request->id)
                ->where('slug',Str::slug($request->newName))
                ->first();

            if ($slug_exist){
                $response['success']  = false;
                $response['errors'][] = 'Slug already exist.';
                return response()->json($response);
            }

            $list = TaxonomyType::where('id',$request->id)->first();

            $list->name = $request->newName;
            $list->slug = Str::slug($request->newName);
            $list->save();

            $response['success'] = true;
            $response['messages'][] = 'Updated Successfully.';
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        $response['data'] = [];
        $response['data']['id'] = $request->id;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateTaxonomyTypePosition(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-manage-taxonomy-type')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $parent_id = null;

            if ($request->parent_id && $request->parent_id != 0) {

                $parent_id = $request->parent_id;
            }

            $item = TaxonomyType::query()
                ->where('id',$request->id)
                ->first();

            $item->parent_id = $parent_id;
            $item->save();

            $response['success'] = true;
            $response['messages'][] = 'Updated Successfully.';
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        $response['data'] = [];
        $response['data']['id'] = $request->id;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getParents(Request $request, $id, $name=null): array
    {
        $list = Taxonomy::query()
            ->where(function($q) use ($name){
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
    public function getCountryById(Request $request, $id): JsonResponse
    {
        try {
            $response = Taxonomy::query()->find($id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
