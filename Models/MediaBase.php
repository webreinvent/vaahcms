<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;


class MediaBase extends Model {

    use SoftDeletes;
    use CrudWithUuidObservantTrait;
    //-------------------------------------------------
    protected $table = 'vh_medias';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    //-------------------------------------------------

    protected $fillable = [
        'name',
        'original_name',
        'uuid',
        'mime_type',
        'extension',
        'path',
        'url',
        'url_thumbnail',
        'size',
        'title',
        'caption',
        'alt_text',
        'is_hidden',
        'is_downloadable',
        'download_url',
        'download_requires_login',
        'meta',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    //-------------------------------------------------
    protected $hidden = [
        'is_hidden',
    ];

    //-------------------------------------------------

    protected $appends  = [
        'type', 'size_for_humans', 'download_url_full'
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
    public function getDownloadUrlFullAttribute() {

        if(!$this->download_url)
        {
            return '';
        }

        return route('vh.frontend.media.download',[$this->download_url]);
    }
    //-------------------------------------------------
    public function getUrlAttribute($value) {

        if(!$value)
        {
            return $value;
        }

        return asset($value);
    }
    //-------------------------------------------------
    public function getTypeAttribute() {
        $explode = explode('/', $this->mime_type);
        return $explode[0];
    }
    //-------------------------------------------------
    public function getUrlThumbnailAttribute($value) {

        if(!$value)
        {
            return null;
        }

        return asset($value);
    }
    //-------------------------------------------------
    public function getSizeForHumansAttribute() {

        $size = $this->size;
        $precision = 2;

        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }
    //-------------------------------------------------
    public function createdByUser()
    {
        return $this->belongsTo(' WebReinvent\VaahCms\Models\User',
            'created_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }
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
            $from = Carbon::parse($from)
                ->startOfDay()
                ->toDateTimeString();
        }

        if($to)
        {
            $to = Carbon::parse($to)
                ->endOfDay()
                ->toDateTimeString();
        }

        $query->whereBetween('created_at',[$from,$to]);
    }

    //-------------------------------------------------
    public function updatedByUser()
    {
        return $this->belongsTo(' WebReinvent\VaahCms\Models\User',
            'updated_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }

    //-------------------------------------------------
    public function deletedByUser()
    {
        return $this->belongsTo(' WebReinvent\VaahCms\Models\User',
            'deleted_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }
    //-------------------------------------------------
    public function mediables()
    {
        return $this->hasMany(Mediable::class, 'vh_media_id', 'id');
    }
    //-------------------------------------------------
    public static function createItem($request)
    {

        $rules = array(
            'name' => 'required',
            'mime_type' => 'required',
            'url' => 'required',
            'path' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        //check download url is set and not taken
        if($request->has('download_url') && !empty($request->download_url))
        {
            $download_url_exist = static::where('download_url', $request->download_url)
            ->first();

            if($download_url_exist)
            {
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-media.download_url_associate');
                return $response;
            }
        }


        $item = new Media();
        $item->fill($request->all());
        $item->save();

        $response['success'] = true;
        $response['data'] = $item;
        $response['messages'][] = trans('vaahcms-general.saved_successfully');

        return $response;
    }
    //-------------------------------------------------
    public static function getList($request)
    {
        $list = self::orderBy('id', 'desc');

        if($request['trashed'] == 'true')
        {
            $list->withTrashed();
        }

        if(isset($request->from) && isset($request->to))
        {
            $list->betweenDates($request['from'],$request['to']);
        }

        if(isset($request->month))
        {

            $date = date_parse($request->month);
            $month = $date['month'];

            $list->whereMonth('created_at', $month);

//            $list->whereIn(\DB::raw('MONTH(column)'), [1,2,3]);
        }

        if(isset($request->year))
        {
            $list->whereYear('created_at', $request->year);
        }

        if(isset($request->q))
        {
            $list->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('type', 'LIKE', '%'.$request->q.'%');
            });
        }

        $list->whereNull('is_hidden');

        $data['list'] = $list->paginate(config('vaahcms.per_page'));


        $response['success'] = true;
        $response['data'] = $data;

        return $response;
    }

    //-------------------------------------------------
    public static function getItem($request)
    {

        if(!\Auth::user()->hasPermission('can-manage-registrations') &&
            !\Auth::user()->hasPermission('can-update-registrations') &&
            !\Auth::user()->hasPermission('can-create-registrations') &&
            !\Auth::user()->hasPermission('can-read-registrations'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");
            return $response;
        }

        $item = static::where('id', $request->id);
        $item->withTrashed();
        $item->with(['createdByUser', 'updatedByUser', 'deletedByUser']);
        $item = $item->first();

        $response['success'] = true;
        $response['data']['item'] = $item;

        return $response;

    }

    //-------------------------------------------------

    //-------------------------------------------------
    public static function postStore($request)
    {

        $rules = array(
            'name' => 'required',
            'mime_type' => 'required',
            'url' => 'required',
            'path' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        //check download url is set and not taken
        if($request->has('download_url') && !empty($request->download_url))
        {
            $download_url_exist = static::where('download_url', $request->download_url)
                ->where('id', '!=', $request->id)
                ->first();

            if($download_url_exist)
            {
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-media.download_url_associate');
                return $response;
            }
        }


        $item = static::where('id', $request->id)->withTrashed()->first();
        $item->fill($request->all());
        $item->save();

        $response['success'] = true;
        $response['data'] = $item;
        $response['messages'][] = 'Save';

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
            $perm = static::where('id',$id)->withTrashed()->first();

            if($perm->deleted_at){
                continue ;
            }

            $perm->save();
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
            $item = static::where('id', $id)->withTrashed()->first();
            if($item)
            {

                $file_path = base_path($item->path);

                if(File::exists($file_path))
                {
                    File::delete($file_path);
                }

                //delete relationship
                $item->mediables()->forceDelete();
                $item->forceDelete();

            }
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
            $item = static::withTrashed()->where('id', $id)->first();
            if($item)
            {
                $item->mediables()->delete();
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
            $item = static::withTrashed()->where('id', $id)->first();
            if(isset($item) && isset($item->deleted_at))
            {
                $item->restore();
                $item->mediables()->restore();
            }
        }

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;

    }
    //-------------------------------------------------
    public static function getDateList()
    {
        $list['month'] = static::select(\DB::raw('MONTHNAME(created_at) month'))
        ->groupby('month')
        ->get();


        $list['year'] = static::select(\DB::raw('YEAR(created_at) year'))
        ->groupby('year')
        ->get();


        return $list;

    }



    //-------------------------------------------------
    //-------------------------------------------------
}
