<?php namespace WebReinvent\VaahCms\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use VaahCms\Modules\Cms\Entities\ContentFormField;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;

class Taxonomy extends Model {

    use SoftDeletes;
    use CrudWithUuidObservantTrait;

    //-------------------------------------------------
    protected $table = 'vh_taxonomies';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i:s',
        'updated_at'  => 'date:Y-m-d H:i:s',
        'deleted_at'  => 'date:Y-m-d H:i:s',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'uuid','parent_id','vh_taxonomy_type_id',
        'name','slug', 'excerpt','details',
        'seo_title','seo_description','seo_keywords',
        'notes','is_active','meta',
        'created_by','updated_by','deleted_by',
    ];

    //-------------------------------------------------
    protected $appends  = [
    ];
    //-------------------------------------------------

    //-------------------------------------------------
    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode($value);
    }
    //-------------------------------------------------
    public function getMetaAttribute($value)
    {
        return json_decode($value);
    }
    //-------------------------------------------------
    public function setSeoKeywordsAttribute($value)
    {
        if(!$value || count($value) === 0){
            $this->attributes['seo_keywords'] = null;
        }else{
            $this->attributes['seo_keywords'] = implode(",",$value);
        }
    }
    //-------------------------------------------------
    public function getSeoKeywordsAttribute($value)
    {
        if(!$value){
            return null;
        }
        return explode(",",$value);
    }
    //-------------------------------------------------

    public function createdByUser()
    {
        return $this->belongsTo(User::class,
            'created_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }

    //-------------------------------------------------
    public function updatedByUser()
    {
        return $this->belongsTo(User::class,
            'updated_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }

    //-------------------------------------------------
    public function deletedByUser()
    {
        return $this->belongsTo(User::class,
            'deleted_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }

    //-------------------------------------------------
    public function type()
    {
        return $this->belongsTo(TaxonomyType::class,
            'vh_taxonomy_type_id', 'id'
        );
    }

    //-------------------------------------------------
    public function parent()
    {
        return $this->belongsTo(self::class,
            'parent_id', 'id'
        )->select('id', 'name', 'slug');
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public function contentFormRelations()
    {
        return $this->morphToMany(ContentFormField::class,
            'relatable',
            'vh_cms_content_form_relations',
            null,'vh_cms_content_form_field_id');
    }

    //-------------------------------------------------
    public function children()
    {
        return $this->hasMany(self::class,
            'parent_id', 'id'
        )->with(['children'])->select('id',  'name as label','name','slug','parent_id');
    }
    //---
    //-------------------------------------------------
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }
    //-------------------------------------------------
    public function scopeExclude($query, $columns)
    {
        return $query->select( array_diff( $this->getTableColumns(),$columns) );
    }

    //-------------------------------------------------
    public function scopeBetweenDates($query, $from, $to)
    {

        if($from)
        {
            $from = \Illuminate\Support\Carbon::parse($from)
                ->startOfDay()
                ->toDateTimeString();
        }

        if($to)
        {
            $to = Carbon::parse($to)
                ->endOfDay()
                ->toDateTimeString();
        }

        $query->whereBetween('updated_at',[$from,$to]);
    }
    //-------------------------------------------------
    //-------------------------------------------------
    public static function createItem($request)
    {

        $inputs = $request->new_item;

        $validation = self::validation($inputs);
        if( isset($validation['status'])
            && $validation['status'] == 'failed'
            )
        {
            return $validation;
        }


        // check if name exist
        $item = self::where('name',$inputs['name'])
            ->withTrashed()->first();

        if($item)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "This name is already exist.";
            return $response;
        }

        // check if slug exist
        $item = self::where('slug',$inputs['slug'])
            ->withTrashed()->first();

        if($item)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "This slug is already exist.";
            return $response;
        }

        if($inputs['parent'] && (is_array($inputs['parent']) || is_object($inputs['parent']))){
            $inputs['parent_id'] = $inputs['parent']['id'];
        }

        $item = new self();
        $item->fill($inputs);
        $item->slug = Str::slug($inputs['slug']);
        $item->save();

        $response['status'] = 'success';
        $response['data']['item'] = $item;
        $response['messages'][] = 'Saved successfully.';
        return $response;

    }
    //-------------------------------------------------
    public static function getList($request)
    {


        $list = self::orderBy('id', 'desc')->with(['parent','type']);

        if($request['trashed'] == 'true')
        {

            $list->withTrashed();
        }

        if(isset($request->from) && isset($request->to))
        {
            $list->betweenDates($request['from'],$request['to']);
        }

        if(isset($request['filter']) &&  $request['filter'])
        {
            if($request['filter'] == '1')
            {
                $list->whereNotNull('is_active');
            }else{
                $list->whereNull('is_active');
            }
        }

        if(isset($request['types']) &&  $request['types'])
        {

            if(is_string($request['types'])){
                $request['types'] = [$request['types']];
            }

            $list->whereIn('vh_taxonomy_type_id',$request['types']);

        }

        if(isset($request->q))
        {

            $list->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
            });
        }


        $data['list'] = $list->paginate(config('vaahcms.per_page'));

        $response['status'] = 'success';
        $response['data'] = $data;

        return $response;


    }
    //-------------------------------------------------
    public static function getItem($id)
    {

        $item = self::where('id', $id)
        ->with(['createdByUser',
            'updatedByUser',
            'deletedByUser',
            'parent',
            'type'])
        ->withTrashed()
        ->first();


        $response['status'] = 'success';
        $response['data'] = $item;

        return $response;

    }
    //-------------------------------------------------
    public static function postStore($request,$id)
    {

        $input = $request->item;


        $validation = self::validation($input);
        if(isset($validation['status']) && $validation['status'] == 'failed')
        {
            return $validation;
        }

        // check if name exist
        $user = self::where('id','!=',$input['id'])
        ->where('name',$input['name'])->withTrashed()->first();

        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "This name is already exist.";
            return $response;
        }


        // check if slug exist
        $user = self::where('id','!=',$input['id'])
        ->where('slug',$input['slug'])->withTrashed()->first();

        if($user)
        {
            $response['status'] = 'failed';
            $response['errors'][] = "This slug is already exist.";
            return $response;
        }

        $input['parent_id'] = null;

        if($input['parent']
            && (is_array($input['parent']) || is_object($input['parent']))){
            $input['parent_id'] = $input['parent']['id'];

        }

        if($input['id'] == $input['parent_id']){
            $response['status'] = 'failed';
            $response['errors'][] = "You can not select yourself as a country.";
            return $response;
        }

        $update = self::where('id',$id)->withTrashed()->first();

        $update->fill($input);
        $update->slug = Str::slug($input['slug']);
        $update->save();


        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Data updated.';

        return $response;

    }
    //-------------------------------------------------
    public static function bulkStatusChange($request)
    {

        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $item = self::where('id',$id)->withTrashed()->first();

            if($item->deleted_at){
                continue ;
            }

            if($request['data']){
                if($request['data']['status'] == 0){
                    $item->is_active = null;
                }else{
                    $item->is_active = $request['data']['status'];
                }
            }else{
                if($item->is_active == 1){
                    $item->is_active = null;
                }else{
                    $item->is_active = 1;
                }
            }
            $item->save();
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;

    }
    //-------------------------------------------------
    public static function bulkTrash($request)
    {


        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }


        foreach($request->inputs as $id)
        {
            $item = self::withTrashed()->where('id', $id)->first();
            if($item)
            {
                $item->delete();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function bulkRestore($request)
    {

        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $item = self::withTrashed()->where('id', $id)->first();
            if(isset($item) && isset($item->deleted_at))
            {
                $item->restore();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;

    }
    //-------------------------------------------------
    public static function bulkDelete($request)
    {

        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $item = self::where('id', $id)->withTrashed()->first();
            if($item)
            {
                $item->forceDelete();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------

    public static function validation($inputs)
    {

        $rules = array(
            'vh_taxonomy_type_id' => 'required',
            'parent' => 'required_if:type,==,Cities',
            'name' => 'required|max:150',
            'slug' => 'required|max:150',
        );


        $messages = array(
            'parent.required_if' => 'The country field is required.',
            'vh_taxonomy_type_id.required' => 'The type field is required.'
        );

        $validator = \Validator::make( $inputs, $rules, $messages);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

    }
    //-------------------------------------------------
    public static function getActiveItems()
    {
        $item = self::whereNotNull('is_active')->get();
        return $item;
    }
    //-------------------------------------------------
    public static function getFirstOrCreate($type, $name)
    {
        $tax_type = TaxonomyType::getFirstOrCreate($type);

        $item =array();

        if(!$tax_type){
            return $item;
        }

        $item = Taxonomy::where('vh_taxonomy_type_id', $tax_type->id)
            ->where('name', $name)
            ->whereNotNull('is_active')
            ->first();

        if(!$item)
        {
            $item = new Taxonomy();
            $item->vh_taxonomy_type_id = $tax_type->id;
            $item->name = $name;
            $item->slug = Str::slug($name);
            $item->is_active = 1;
            $item->save();
        }

        return $item;
    }
    //-------------------------------------------------
    public static function getTaxonomyByType($type)
    {
        $tax_type = TaxonomyType::getFirstOrCreate($type);

        $item =array();

        if(!$tax_type){
            return $item;
        }

        $item = self::whereNotNull('is_active')
            ->where('vh_taxonomy_type_id',$tax_type->id)
            ->get();
        return $item;
    }
    //-------------------------------------------------
    public static function getTaxonomyByTypeInTreeFormat($type)
    {
        $tax_type = TaxonomyType::getFirstOrCreate($type);

        $item =array();

        if(!$tax_type){
            return $item;
        }

        $item = self::whereNotNull('is_active')
            ->with(['children'])
            ->where('vh_taxonomy_type_id',$tax_type->id)
            ->select('id',  'name as label','name','slug','parent_id')
            ->get();
        return $item;
    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------


}
