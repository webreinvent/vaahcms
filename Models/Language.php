<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahCms\Traits\CrudObservantTrait;

class Language extends Model {

    use SoftDeletes;
    use CrudObservantTrait;

    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_lang_languages';
    //-------------------------------------------------
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'name',
        'locale_code_iso_639',
        'right_to_left',
        'default',
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
    //-------------------------------------------------


    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

    }
    //-------------------------------------------------

    //-------------------------------------------------
    public function getNameAttribute($value) {
        return ucwords($value);
    }
    //-------------------------------------------------
    public function scopeLocaleCode( $query, $code ) {
        return $query->where( 'locale_code_iso_639', $code );
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
            'vh_lang_language_id', 'id'
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
            'locale_code_iso_639' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
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

            $item = static::where('locale_code_iso_639', Str::slug( $inputs['locale_code_iso_639'] ))->first();

            if($item)
            {
                $response['success'] = false;
                $response['messages'][] = trans('vaahcms-localization.locale_code_already_exist');
                return $response;
            }

            $item = new static();
        }

        $item->fill($inputs);
        $item->save();

        $response['success'] = true;
        $response['messages'][] = 'Saved';
        $response['data'] = $item;

        return $response;


    }
    //-------------------------------------------------
    public static function getLangList()
    {
        $lang_list =  Language::orderBy('default','desc')->get();

        foreach ($lang_list as $item){
            $total = LanguageString::where('vh_lang_language_id',$item->id)->count();
            $not_empty = LanguageString::where('vh_lang_language_id',$item->id)->whereNOtNull('content')->count();

            $item['option_label'] = $item->name.' ('.$not_empty.'/'.$total.')';
            $item['total'] = $total;
            $item['not_empty'] = $not_empty;

        }
        return $lang_list;
    }
    //-------------------------------------------------
    //-------------------------------------------------


}
