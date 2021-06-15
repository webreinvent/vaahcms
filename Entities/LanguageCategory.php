<?php namespace WebReinvent\VaahCms\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudObservantTrait;

class LanguageCategory extends Model {

    use SoftDeletes;
    use CrudObservantTrait;

    //-------------------------------------------------
    protected $table = 'vh_lang_categories';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'name',
        'slug',
        'count_strings',
        'count_strings_filled',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    //-------------------------------------------------
    protected $appends  = [
    ];

    //-------------------------------------------------

    protected $casts = [
        "created_at" => 'date:Y-m-d H:i:s',
        "updated_at" => 'date:Y-m-d H:i:s',
        "deleted_at" => 'date:Y-m-d H:i:s'
    ];
    //-------------------------------------------------
    public function setSlugAttribute( $value ) {
        $this->attributes['slug'] = Str::slug( $value );
    }
    //-------------------------------------------------
    public function getNameAttribute($value) {
        return ucwords($value);
    }
    //-------------------------------------------------
    public function scopeSlug( $query, $slug ) {
        return $query->where( 'slug', $slug );
    }
    //-------------------------------------------------
    public function scopeCreatedBy( $query, $user_id ) {
        return $query->where( 'created_by', $user_id );
    }

    //-------------------------------------------------
    public function scopeUpdatedBy( $query, $user_id ) {
        return $query->where( 'updated_by', $user_id );
    }

    //-------------------------------------------------
    public function scopeDeletedBy( $query, $user_id ) {
        return $query->where( 'deleted_by', $user_id );
    }

    //-------------------------------------------------
    public function scopeCreatedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'created_at', array( $from, $to ) );
    }

    //-------------------------------------------------
    public function scopeUpdatedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'updated_at', array( $from, $to ) );
    }

    //-------------------------------------------------
    public function scopeDeletedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'deleted_at', array( $from, $to ) );
    }
    //-------------------------------------------------
    public function createdBy() {
        return $this->belongsTo( User::class,
            'created_by', 'id'
        );
    }
    //-------------------------------------------------
    public function updatedBy() {
        return $this->belongsTo( User::class,
            'updated_by', 'id'
        );
    }
    //-------------------------------------------------
    public function deletedBy() {
        return $this->belongsTo( User::class,
            'deleted_by', 'id'
        );
    }
    //-------------------------------------------------
    public function strings() {
        return $this->hasMany( LanguageString::class,
            'vh_lang_category_id', 'id'
        );
    }
    //-------------------------------------------------
    public function stringsFilled() {
        return $this->hasMany( LanguageString::class,
            'vh_lang_language_id', 'id'
        )->whereNotNull('vh_lang_strings.content');
    }
    //-------------------------------------------------
    public static function countStrings($id)
    {
        $item = static::withTrashed()->where('id', $id)->first();

        if(!$item)
        {
            return 0;
        }

        return $item->strings()->count();
    }
    //-------------------------------------------------
    public static function countStringsFilled($id)
    {
        $item = static::withTrashed()->where('id', $id)->first();

        if(!$item)
        {
            return 0;
        }

        return $item->stringsFilled()->count();
    }
    //-------------------------------------------------
    public static function countRelations()
    {
        $list = static::withTrashed()->select('id')->get();

        if($list)
        {
            foreach ($list as $item)
            {
                $item->count_strings = static::countStrings($item->id);
                $item->count_strings_filled = static::countStringsFilled($item->id);
                $item->save();
            }
        }
    }
    //-------------------------------------------------
    public static function store($request)
    {
        $rules = array(
            'name' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $data = [];

        $inputs = $request->all();

        if($request->has('id'))
        {
            $item = static::find($request->id);
        } else
        {

            $item = static::where('slug', Str::slug( $inputs['name'] ))->first();

            if($item)
            {
                $response['status'] = 'failed';
                $response['errors'][] = 'Record already exist';
                return $response;
            }

            $item = new static();
        }

        $inputs['slug'] = Str::slug( $inputs['name'] );

        $item->fill($inputs);
        $item->save();

        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data'] = $item;

        return $response;


    }
    //-------------------------------------------------
    //-------------------------------------------------


}
