<?php namespace WebReinvent\VaahCms\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudObservantTrait;

class LanguageString extends Model {

    use SoftDeletes;
    use CrudObservantTrait;

    //-------------------------------------------------
    protected $table = 'vh_lang_strings';
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
        'vh_lang_language_id',
        'vh_lang_category_id',
        'name',
        'slug',
        'content',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    //-------------------------------------------------
    protected $appends  = [
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
    public function language() {
        return $this->belongsTo( Language::class,
            'vh_lang_language_id', 'id'
        );
    }
    //-------------------------------------------------
    public function languageCategory() {
        return $this->belongsTo( LanguageCategory::class,
            'vh_lang_category_id', 'id'
        );
    }
    //-------------------------------------------------
    public static function updateRelationsCount()
    {
        Language::countRelations();
        LanguageCategory::countRelations();
    }
    //-------------------------------------------------
    public static function syncStrings()
    {
        //get default languages
        $lang = Language::where('default', 1)->first();

        //get all strings of default lang
        $strings = static::where('vh_lang_language_id', $lang->id)
            ->whereNotNull('slug')
            ->get();

        $languages = Language::all();
        $categories = LanguageCategory::all();

        if(!$strings)
        {
            return false;
        }

        foreach ($strings as $string)
        {
            foreach ($languages as $language)
            {
                foreach ($categories as $category)
                {

                    $insert = [];
                    $insert['vh_lang_language_id'] = $language->id;
                    $insert['vh_lang_category_id'] = $category->id;
                    $insert['name'] = $string->name;
                    $insert['slug'] = \Str::slug($string->name);

                    $exist = static::where('vh_lang_language_id', $language->id)
                        ->where('vh_lang_category_id', $language->id)
                        ->where('slug', $insert['slug'])
                        ->first();

                    if(!$exist)
                    {
                        $new_string = new static();
                        $new_string->fill($insert);
                        $new_string->save();
                    }

                }
            }
        }

        return true;

    }
    //-------------------------------------------------
    public static function getList($request)
    {

        $list = static::orderBy('created_at', 'asc');

        $list->where('vh_lang_language_id', $request->vh_lang_language_id);
        $list->where('vh_lang_category_id', $request->vh_lang_category_id);

        $list = $list->get();

        $response['status'] = 'success';
        $response['data']['list'] = $list;

        return $response;

    }
    //-------------------------------------------------
    //-------------------------------------------------


}
