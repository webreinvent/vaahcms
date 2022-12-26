<?php namespace WebReinvent\VaahCms\Models;

use Carbon\Carbon;
use DateTimeInterface;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;
use WebReinvent\VaahCms\Models\User;

class Registration extends RegistrationBase
{

    use SoftDeletes;
    use CrudWithUuidObservantTrait;

    //-------------------------------------------------
    protected $table = 'vh_registrations';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $fillable = [
        'uuid',

        'email', 'username', 'password', 'display_name',
        'designation','title', 'first_name', 'middle_name',
        'last_name', 'gender', 'country_calling_code', 'phone',
        'bio', 'timezone', 'alternate_email', 'avatar_url',
        'birth', 'country', 'country_code', 'status',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    //-------------------------------------------------
    protected $appends = [
    ];


    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');
        return $date->format($date_time_format);
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
    public static function createItem($request)
    {

        $inputs = $request->all();



//        dd($password);

        $validation = self::validation($inputs);
        if (!$validation['success']) {
            return $validation;
        }



        // check if email exist
        $item = self::where('email', $inputs['email'])->first();

        if ($item) {
            $response['success'] = false;
            $response['messages'][] = "This email is already exist.";
            return $response;
        }
        if($inputs['email'] && $inputs['alternate_email']
            && $inputs['email']==$inputs['alternate_email'] )
        {
             $response['success'] = false;
             $response['messages'][] = "The alternate email id should be different";
             return $response;
        }

        // check if slug exist
       /* $item = self::where('slug', $inputs['slug'])->first();

        if ($item) {
            $response['success'] = false;
            $response['messages'][] = "This slug is already exist.";
            return $response;
        }*/

        $item = new self();
        $item->fill($inputs);
//        $item->slug = Str::slug($inputs['slug']);
        $item->save();
//        dd($item);


        $response['success'] = true;
        $response['data']['item'] = $item;
        $response['messages'][] = 'Saved successfully.';
        return $response;

    }

    //-------------------------------------------------
    public function scopeGetSorted($query, $filter)
    {
//        dd($filter);

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
            $q->where('first_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('display_name', 'LIKE', '%'.$search.'%')
                    ->orWhere(\DB::raw('concat(first_name," ",middle_name," ",last_name)'), 'like', '%'.$search.'%')
                    ->orWhere(\DB::raw('concat(first_name," ",last_name)'), 'like', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->orWhere('id', '=', $search);
        });


    }
    //-------------------------------------------------
    public static function getList($request,$excluded_columns = [])
    {
//        dd($request->filter);
        $list = self::getSorted($request->filter);
        $list->isActiveFilter($request->filter);
        $list->trashedFilter($request->filter);
        $list->searchFilter($request->filter);

        $rows = config('vaahcms.per_page');

        if($request->has('rows'))
        {
            $rows = $request->rows;
        }

        $list = $list->paginate($rows);

        $response['success'] = true;
        $response['data'] = $list;

        return $response;


    }

    //-------------------------------------------------
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
    public static function getItem($id,$excluded_columns = [])
    {

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

        $validation = self::validation($inputs,$id);
        if (!$validation['success']) {
            return $validation;
        }
        if($inputs['email'] && $inputs['alternate_email']
            && $inputs['email']==$inputs['alternate_email'] )
        {
             $response['success'] = false;
             $response['messages'][] = "This alternate email should be different";
             return $response;
        }

        // check if name exist
       /* $user = self::where('id', '!=', $inputs['id'])
            ->where('name', $inputs['name'])->first();

        if ($user) {
            $response['success'] = false;
            $response['messages'][] = "This name is already exist.";
            return $response;
        }



        // check if slug exist
        $user = self::where('id', '!=', $inputs['id'])
            ->where('slug', $inputs['slug'])->first();

        if ($user) {
            $response['success'] = false;
            $response['messages'][] = "This slug is already exist.";
            return $response;
        }*/

        $update = self::where('id', $id)->withTrashed()->first();
        $update->fill($inputs);
//        $update->slug = Str::slug($inputs['slug']);
        $update->save();

//        $response = self::getItem($id);
        $item = self::getItem($id);
//        dd($item);

        $response['success'] = true;
        $response['data']['item'] = $item['data'];
        $response['messages'][] = 'Saved successfully.';
//        dd($response);

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
//        dd($type);
        switch($type)
        {
            case 'activate':
                self::where('id', $id)
                    ->withTrashed()
                    ->update(['is_active' => 1]);
                break;
            case 'deactivate':
                self::where('id', $id)
                    ->withTrashed()
                    ->update(['is_active' => null]);
                break;
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

    public static function validation($inputs, $id=null)
    {

        $rules = array(
//            'name' => 'required|max:150',
//            'slug' => 'required|max:150',
            'id'=>'nullable',

            'email' => "required|email|unique:vh_registrations,email,$id",
            'username' => "required|string|max:25|unique:vh_registrations,username,$id",
            'password' => 'required_if:id,null|string|min:6',
            'display_name' => 'required|string|max:150',

            'designation' => 'required|max:150',
            'title' => 'required',
            'first_name' => 'required|string|max:150',
            'middle_name' => 'nullable|string|max:150',

            'last_name' => 'required|string|max:150',
            'gender' => 'required',
            'country_calling_code' => 'required',
//            'country_code' => 'required',

            'phone' => 'required|numeric|digits:10',
            'bio' => 'required|max:250',
            'alternate_email' => 'required|email',
            'birth' => 'required|date|before:today',

            'timezone' => 'required',
            'status' => 'required',
            'country' => 'required',
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
    public static function getActiveItems()
    {
        $item = self::where('is_active', 1)
            ->first();
        return $item;
    }
    public function getCountryCallingCodeAttribute($value)
    {
        $calling_code_int=$value;
        $calling_code_string=(string) $calling_code_int;
        return $calling_code_string;
    }
    /*public function getGenderAttribute($value)
    {
        if($value=='M'){
            return 'Male';
        }
        elseif ($value=='F'){
            return 'Female';
        }
        else{
            return 'Others';
        }
    }*/


    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------


}
