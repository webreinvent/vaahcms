<?php namespace WebReinvent\VaahCms\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use VaahCms\Modules\Cms\Entities\ContentFormField;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;

class TaxonomyBase extends Model {

    use SoftDeletes;
    use CrudWithUuidObservantTrait;

    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_taxonomies';
    //-------------------------------------------------
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    //-------------------------------------------------
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'uuid','parent_id','vh_taxonomy_type_id',
        'name','slug', 'excerpt','details',
        'notes','is_active','meta',
        'created_by','updated_by','deleted_by',
    ];

    //-------------------------------------------------
    protected $appends  = [
    ];
    //-------------------------------------------------


    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

    }
    //-------------------------------------------------
    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode($value);
    }
    //-------------------------------------------------
    public function getMetaAttribute($value)
    {
        if($value && $value!='null'){
            return json_decode($value);
        }else{
            return json_decode('{}');
        }

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
        if( isset($validation['success']) && !$validation['success'] )
        {
            return $validation;
        }


        // check if name exist
        $item = self::where('name',$inputs['name'])
            ->where('vh_taxonomy_type_id',$inputs['vh_taxonomy_type_id'])
            ->withTrashed()->first();

        if($item)
        {
            $response['success'] = false;
            $response['errors'][] = "This name is already exist.";
            return $response;
        }

        // check if slug exist
        $item = self::where('slug',$inputs['slug'])
            ->where('vh_taxonomy_type_id',$inputs['vh_taxonomy_type_id'])
            ->withTrashed()->first();

        if($item)
        {
            $response['success'] = false;
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

        $response['success'] = true;
        $response['data'] = $item;
        $response['messages'][] = trans('vaahcms-general.saved_successfully');
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


        $response['success'] = true;
        $response['data'] = $item;

        return $response;

    }
    //-------------------------------------------------
    public static function postStore($request,$id)
    {

        $input = $request->item;


        $validation = self::validation($input);
        if(isset($validation['success']) && !$validation['success'])
        {
            return $validation;
        }

        // check if name exist
        $user = self::where('id','!=',$input['id'])
            ->where('vh_taxonomy_type_id',$input['vh_taxonomy_type_id'])
        ->where('name',$input['name'])->withTrashed()->first();

        if($user)
        {
            $response['success'] = false;
            $response['errors'][] = "This name is already exist.";
            return $response;
        }


        // check if slug exist
        $user = self::where('id','!=',$input['id'])
            ->where('vh_taxonomy_type_id',$input['vh_taxonomy_type_id'])
        ->where('slug',$input['slug'])->withTrashed()->first();

        if($user)
        {
            $response['success'] = false;
            $response['errors'][] = "This slug is already exist.";
            return $response;
        }

        $input['parent_id'] = null;

        if($input['parent']
            && (is_array($input['parent']) || is_object($input['parent']))){
            $input['parent_id'] = $input['parent']['id'];

        }

        if($input['id'] == $input['parent_id']){
            $response['success'] = false;
            $response['errors'][] = "You can not select yourself as a country.";
            return $response;
        }

        $update = self::where('id',$id)->withTrashed()->first();

        $update->fill($input);
        $update->slug = Str::slug($input['slug']);
        $update->save();


        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = 'Data updated.';

        return $response;

    }
    //-------------------------------------------------
    public static function bulkStatusChange($request)
    {

        if(!$request->has('inputs'))
        {
            $response['success'] = false;
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['success'] = false;
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

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;

    }
    //-------------------------------------------------
    public static function bulkTrash($request)
    {


        if(!$request->has('inputs'))
        {
            $response['success'] = false;
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

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------
    public static function bulkRestore($request)
    {

        if(!$request->has('inputs'))
        {
            $response['success'] = false;
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['success'] = false;
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

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;

    }
    //-------------------------------------------------
    public static function bulkDelete($request)
    {

        if(!$request->has('inputs'))
        {
            $response['success'] = false;
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['success'] = false;
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

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

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
            $response['success'] = false;
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

        $item = TaxonomyBase::where('vh_taxonomy_type_id', $tax_type->id)
            ->where('name', $name)
            ->whereNotNull('is_active')
            ->first();

        if(!$item)
        {
            $item = new TaxonomyBase();
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
