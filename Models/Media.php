<?php namespace WebReinvent\VaahCms\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;
use WebReinvent\VaahCms\Models\User;

class Media extends Model
{
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
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }

    //-------------------------------------------------
    public function scopeExclude($query, $columns)
    {
        return $query->select(array_diff($this->getTableColumns(), $columns));
    }

    //-------------------------------------------------
    public function scopeBetweenDates($query, $from, $to)
    {

        if ($from) {
            $from = \Carbon::parse($from)
                ->startOfDay()
                ->toDateTimeString();
        }

        if ($to) {
            $to = \Carbon::parse($to)
                ->endOfDay()
                ->toDateTimeString();
        }

        $query->whereBetween('updated_at', [$from, $to]);
    }

    //-------------------------------------------------
    public function scopeGetSorted($query, $filter)
    {

        if(!isset($filter['sort']))
        {
            return $query->orderBy('id', 'desc');
        }

        $sort = $filter['sort'];


        $direction = Str::contains($sort, ':');

        if(!$direction)
        {
            return $query->orderBy($sort, 'asc');
        }

        $sort = explode(':', $sort);

        return $query->orderBy($sort[0], $sort[1]);
    }
    //-------------------------------------------------
    public function scopeIsActiveFilter($query, $filter)
    {

        if(!isset($filter['is_active'])
            || is_null($filter['is_active'])
            || $filter['is_active'] === 'null'
        )
        {
            return $query;
        }
        $is_active = $filter['is_active'];

        if($is_active === 'true' || $is_active === true)
        {
            return $query->whereNotNull('is_active');
        } else{
            return $query->whereNull('is_active');
        }

    }
    //-------------------------------------------------
    public function scopeTrashedFilter($query, $filter)
    {

        if(!isset($filter['trashed']))
        {
            return $query;
        }
        $trashed = $filter['trashed'];

        if($trashed === 'include')
        {
            return $query->withTrashed();
        } else if($trashed === 'only'){
            return $query->onlyTrashed();
        }

    }
    //-------------------------------------------------
    public function scopeSearchFilter($query, $filter)
    {

        if(!isset($filter['q']))
        {
            return $query;
        }
        $search = $filter['q'];
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('extension', 'LIKE', '%' . $search . '%');
        });

    }

    public static function updateList($request)
    {

        $inputs = $request->all();

        $rules = array(
            'type' => 'required',
        );

        $messages = array(
            'type.required' => 'Action type is required',
        );


        $validator = \Validator::make($inputs, $rules, $messages);
        if ($validator->fails()) {

            $errors = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        if(isset($inputs['items']))
        {
            $items_id = collect($inputs['items'])
                ->pluck('id')
                ->toArray();
        }


        $items = self::whereIn('id', $items_id)
            ->withTrashed();

        switch ($inputs['type']) {
            case 'deactivate':
                $items->update(['is_active' => null]);
                break;
            case 'activate':
                $items->update(['is_active' => 1]);
                break;
            case 'trash':
                self::whereIn('id', $items_id)->delete();
                break;
            case 'restore':
                self::whereIn('id', $items_id)->restore();
                break;
        }

        $response['success'] = true;
        $response['data'] = true;
        $response['messages'][] = 'Action was successful.';

        return $response;
    }

    //-------------------------------------------------
    public static function deleteList($request): array
    {
        $inputs = $request->all();

        $rules = array(
            'type' => 'required',
            'items' => 'required',
        );

        $messages = array(
            'type.required' => 'Action type is required',
            'items.required' => 'Select items',
        );

        $validator = \Validator::make($inputs, $rules, $messages);
        if ($validator->fails()) {

            $errors = errorsToArray($validator->errors());
            $response['failed'] = true;
            $response['messages'] = $errors;
            return $response;
        }

        $items_id = collect($inputs['items'])->pluck('id')->toArray();
        self::whereIn('id', $items_id)->forceDelete();

        $response['success'] = true;
        $response['data'] = true;
        $response['messages'][] = 'Action was successful.';

        return $response;
    }
    //-------------------------------------------------
    public static function listAction($request, $type): array
    {
        $inputs = $request->all();

        if(isset($inputs['items']))
        {
            $items_id = collect($inputs['items'])
                ->pluck('id')
                ->toArray();

            $items = self::whereIn('id', $items_id)
                ->withTrashed();
        }


        switch ($type) {
            case 'deactivate':
                if($items->count() > 0) {
                    $items->update(['is_active' => null]);
                }
                break;
            case 'activate':
                if($items->count() > 0) {
                    $items->update(['is_active' => 1]);
                }
                break;
            case 'trash':
                if(isset($items_id) && count($items_id) > 0) {
                    self::whereIn('id', $items_id)->delete();
                }
                break;
            case 'restore':
                if(isset($items_id) && count($items_id) > 0) {
                    self::whereIn('id', $items_id)->restore();
                }
                break;
            case 'delete':
                if(isset($items_id) && count($items_id) > 0) {
                    self::whereIn('id', $items_id)->forceDelete();
                }
                break;
            case 'activate-all':
                self::query()->update(['is_active' => 1]);
                break;
            case 'deactivate-all':
                self::query()->update(['is_active' => null]);
                break;
            case 'trash-all':
                self::query()->delete();
                break;
            case 'restore-all':
                self::withTrashed()->restore();
                break;
            case 'delete-all':
                self::withTrashed()->forceDelete();
                break;
        }

        $response['success'] = true;
        $response['data'] = true;
        $response['messages'][] = 'Action was successful.';

        return $response;
    }
    //-------------------------------------------------
    public static function getItem($id)
    {
        if(!Auth::user()->hasPermission('has-access-of-media-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");
            return $response;
        }

        $item = self::where('id', $id)
            ->with(['createdByUser', 'updatedByUser', 'deletedByUser'])
            ->withTrashed()
            ->first();

        if(!$item)
        {
            $response['success'] = false;
            $response['errors'][] = 'Record not found with ID: '.$id;
            return $response;
        }
        $response['success'] = true;
        $response['data'] = $item;

        return $response;

    }
    //-------------------------------------------------
    public static function updateItem($request, $id)
    {
        $inputs = $request->all();

        $validation = self::validation($inputs);
        if (!$validation['success']) {
            return $validation;
        }

        // check if name exist
        $item = self::where('id', '!=', $inputs['id'])
            ->withTrashed()
            ->where('name', $inputs['name'])->first();

        if ($item) {
            $response['success'] = false;
            $response['messages'][] = "This name is already exist.";
            return $response;
        }

        // check if slug exist
        $item = self::where('id', '!=', $inputs['id'])
            ->withTrashed()
            ->where('slug', $inputs['slug'])->first();

        if ($item) {
            $response['success'] = false;
            $response['messages'][] = "This slug is already exist.";
            return $response;
        }

        $item = self::where('id', $id)->withTrashed()->first();
        $item->fill($inputs);
        $item->slug = Str::slug($inputs['slug']);
        $item->save();

        $response = self::getItem($item->id);
        $response['messages'][] = 'Saved successfully.';
        return $response;

    }
    //-------------------------------------------------
    public static function deleteItem($request, $id): array
    {
        $item = self::where('id', $id)->withTrashed()->first();
        if (!$item) {
            $response['success'] = false;
            $response['messages'][] = 'Record does not exist.';
            return $response;
        }
        $item->forceDelete();

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = 'Record has been deleted';

        return $response;
    }
    //-------------------------------------------------
    public static function itemAction($request, $id, $type): array
    {
        switch($type)
        {
            case 'trash':
                self::find($id)->delete();
                break;
            case 'restore':
                self::where('id', $id)
                    ->withTrashed()
                    ->restore();
                break;
        }

        return self::getItem($id);
    }
    //-------------------------------------------------

    public static function validation($inputs)
    {

        $rules = array(
            'name' => 'required|max:150',
            'slug' => 'required|max:150',
        );

        $validator = \Validator::make($inputs, $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $response['success'] = false;
            $response['messages'] = $messages->all();
            return $response;
        }

        $response['success'] = true;
        return $response;

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

        if(isset($request->filter['trashed']) && ($request->filter['trashed'] == 'true'))
        {
            $list->withTrashed();
        }

        if(isset($request->filter['from']) && isset($request->filter['to']))
        {
            $list->whereBetween('created_at',[$request->filter['from'],$request->filter['to']]);
        }

        if(isset($request->filter['month']))
        {
            $date = date_parse($request->filter['month']);
            $month = $date['month'];

            $list->whereMonth('created_at', $month);

            //$list->whereIn(\DB::raw('MONTH(column)'), [1,2,3]);
        }

        if(isset($request->filter['year']))
        {
            $list->whereYear('created_at', $request->filter['year']);
        }

        if(isset($request->filter['q']))
        {
            $filter = $request->filter['q'];
            $list->where(function ($q) use ($filter){
                $q->where('name', 'LIKE', '%'.$filter.'%')
                    ->orWhere('title', 'LIKE', '%'.$filter.'%');
            });
        }

        $list->whereNull('is_hidden');

        $data['list'] = $list->skip(($request->rows * $request->page))
            ->take($request->rows)->paginate($request->rows);

        $response['success'] = true;
        $response['data'] = $data;

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
}
