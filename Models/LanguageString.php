<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahCms\Traits\CrudObservantTrait;

class LanguageString extends Model {

    use SoftDeletes;
    use CrudObservantTrait;

    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_lang_strings';
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

    //-------------------------------------------------


    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

    }
    //-------------------------------------------------
    public function setSlugAttribute( $value ) {
        $this->attributes['slug'] = Str::slug( $value, '_' );
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
    public static function syncStrings($request)
    {
        //get default languages
        if($request->has('vh_lang_language_id'))
        {
            $lang = Language::where('id', $request->vh_lang_language_id)->first();
        } else
        {
            $lang = Language::where('default', 1)->first();
        }

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

                $insert = [];
                $insert['vh_lang_language_id'] = $language->id;
                $insert['vh_lang_category_id'] = $string->vh_lang_category_id;
                $insert['name'] = $string->name;
                $insert['slug'] = $string->slug;

                if(!$string->slug){
                    $insert['slug'] = \Str::slug($string->name, "_");
                }

                $exist = static::where('vh_lang_language_id', $language->id)
                    ->where('vh_lang_category_id', $string->vh_lang_category_id)
                    ->where('slug', $insert['slug'])
                    ->first();

                if(!$exist)
                {
                    $new_string = new static();
                    $insert['content']=null;
                    $new_string->fill($insert);
                    $new_string->save();
                }
            }
        }

        return true;

    }
    //-------------------------------------------------
    public static function getList($request)
    {
        if($request->sync && $request->sync != 'false'){
            LanguageString::syncAndGenerateStrings($request);
        }

        $list = static::orderBy('created_at', 'desc');

        $list->where('vh_lang_language_id', $request->vh_lang_language_id);

        if($request->filter && $request->filter == 'filled'){

            $list->whereNotNull('content');
        }elseif($request->filter && $request->filter == 'empty'){
            $list->whereNull('content');
        }

        if($request->vh_lang_category_id){
            $list->where('vh_lang_category_id', $request->vh_lang_category_id);
        }

        $list = $list->with('languageCategory')->paginate($request->rows);

        $response['success'] = true;
        $response['data']['list'] = $list;

        return $response;

    }
    //-------------------------------------------------
    public static function storeList($request)
    {

        if(!is_array($request->list) || count($request->list) < 1)
        {

            $response['success'] = false;
            $response['messages'][] = trans('vaahcms-localization.one_string_required');
            return $response;

        }

        foreach($request->list as $item)
        {
            $string = null;

            if(!$item['slug']){
                continue;
            }


            if(isset($item['id']))
            {
                $string = static::find($item['id']);

                if(!$string)
                {
                    $string = new static();
                }

            } else
            {
                if(!$item['vh_lang_category_id'])
                {

                    $cat = LanguageCategory::where('slug', 'general')->first();

                    $item['vh_lang_category_id'] = $cat->id;

                }

                //find based on slug
                $string = static::where('slug', $item['slug'])
                    ->where('vh_lang_language_id', $item['vh_lang_language_id'])
                    ->where('vh_lang_category_id', $item['vh_lang_category_id'])
                    ->first();

                if(!$string)
                {
                    $string = new static();
                }

            }



            if(!isset($item['name']))
            {
                $item['name'] = $item['slug'];
            }


            $string->fill($item);
            $string->save();

        }

        static::syncStrings($request);


        //Generate a language file


        $response['success'] = true;
        $response['data'][] = '';
        $response['messages'][] = trans('vaahcms-general.action_successful');
        return $response;


    }
    //-------------------------------------------------
    public static function deleteItem($request)
    {

        $rules = array(
            'slug' => 'required|max:150',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        static::where('slug', $request->slug)->forceDelete();

        $response['success'] = true;
        $response['data'][] = '';
        return $response;

    }
    //-------------------------------------------------
    public static function generateLangFiles()
    {

        $languages = Language::all();
        $categories = LanguageCategory::all();

        self::deleteVaahCmsLangFiles();

        if(count($languages) > 0)
        {
            foreach ($languages as $language)
            {

                foreach ($categories as $category)
                {
                    $strings = static::where('vh_lang_language_id', $language->id)
                        ->where('vh_lang_category_id', $category->id)
                        ->whereNotNull('slug')
                        ->whereNotNull('content')
                        ->get();

                    $folder_path = 'resources/lang/'.$language->locale_code_iso_639;

                    $file_name = 'vaahcms-'.$category->slug.'.php';

                    $file_path = base_path($folder_path.'/'.$file_name);

                    File::delete($file_path);

                    if($strings->count() > 0)
                    {
                        $inputs = [
                            "language" => $language,
                            "category" => $category,
                            "strings" => $strings,
                        ];

                        $html = view('vaahcms::templates.lang')
                            ->with($inputs)
                            ->render();
                        $html = html_entity_decode($html);

                        $html = "<?php "."\n".$html;

                        $folder_path_relative = base_path($folder_path);

                        if(!File::exists($folder_path_relative)) {
                            File::makeDirectory($folder_path_relative, 0755, true, true);
                        }

                        File::put($file_path, $html);
                    }


                }

            }

        }



    }
    //-------------------------------------------------
    public static function deleteVaahCmsLangFiles()
    {

        //delete existing language files
        $file_path = base_path('resources/lang');

        $folders = vh_get_all_files($file_path);

        if(count($folders) > 0)
        {
            foreach ($folders as $folder)
            {

                $files = vh_get_all_files($file_path."/".$folder);

                if(count($files) > 0)
                {
                    foreach ($files as $file)
                    {
                        if(strpos($file, 'vaahcms') !== false && !File::isDirectory($file)) {
                            unlink($file_path.'/'.$folder.'/'.$file);
                        }
                    }


                }

            }
        }

    }

    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    public static function syncAndGenerateStrings($request)
    {
        LanguageString::syncStrings($request);
        LanguageString::generateLangFiles();

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
    }
    //-------------------------------------------------


}
