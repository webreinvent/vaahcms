<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Jobs\ProcessNotifications;
use WebReinvent\VaahCms\Models\UserBase as User;
use WebReinvent\VaahCms\Notifications\Notice;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;

class Notification extends Model {

    use SoftDeletes;
    use CrudWithUuidObservantTrait;

    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_notifications';
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
        'uuid',
        'name',
        'slug',
        'details',
        'via_mail',
        'via_sms',
        'via_push',
        'via_frontend',
        'via_backend',
        'is_error',
        'can_update_via',
        'created_by',
        'updated_by',
        'deleted_by'
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
    public function scopeSlug( $query, $slug ) {
        return $query->where( 'slug', $slug );
    }

    //-------------------------------------------------
    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords($value);
    }
    //-------------------------------------------------
    public function getViaMailAttribute($value) {
        if($value)
        {
            return true;
        }
        return false;
    }
    //-------------------------------------------------
    public function getViaSmsAttribute($value) {
        if($value)
        {
            return true;
        }
        return false;
    }
    //-------------------------------------------------
    public function getViaPushAttribute($value) {
        if($value)
        {
            return true;
        }
        return false;
    }
    //-------------------------------------------------
    public function getViaBackendAttribute($value) {
        if($value)
        {
            return true;
        }
        return false;
    }
    //-------------------------------------------------
    public function getViaFrontendAttribute($value) {
        if($value)
        {
            return true;
        }
        return false;
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
    public function createdByUser()
    {
        return $this->belongsTo(' WebReinvent\VaahCms\Models\User',
            'created_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
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
    public function contents()
    {
        return $this->hasMany(NotificationContent::class,
            'vh_notification_id', 'id'
        );
    }
    //-------------------------------------------------
    public static function createItem($request)
    {
        $response = [];

        try {
            if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
                $response['success'] = false;
                $response['errors'][] = trans("vaahcms::messages.permission_denied");
                return $response;
            }

            $input = $request->item;
            $rows = $request->rows;

            $rules = [
                'name' => 'required|unique:vh_notifications',
            ];

            $validator = \Validator::make($input, $rules);

            if ($validator->fails()) {
                $errors = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return $response;
            }

            $item = new self();
            $item->fill($input);
            $item->slug = Str::slug($input['name']);
            $item->save();

            $response['success'] = true;
            $response['messages'][] = 'Saved';
            $response['data']['item'] = $item;
        } catch (\Exception $e) {
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;
    }

    //-------------------------------------------------
    public function scopeGetSorted($query, $filter)
    {
        if( !isset($filter['sort'])) {
            return $query->orderBy('id', 'desc');
        }

        $sort = $filter['sort'];

        $direction = Str::contains($sort, ':');

        if (!$direction) {
            return $query->orderBy($sort, 'asc');
        }

        $sort = explode(':', $sort);

        return $query->orderBy($sort[0], $sort[1]);
    }
    //-------------------------------------------------
    public function scopeTrashedFilter($query, $filter)
    {
        if (!isset($filter['trashed'])) {
            return $query;
        }

        $trashed = $filter['trashed'];

        if ($trashed === 'include') {
            return $query->withTrashed();
        } else if($trashed === 'only'){
            return $query->onlyTrashed();
        }
    }
    //-------------------------------------------------
    public function scopeSearchFilter($query, $filter)
    {
        if (!isset($filter['q'])) {
            return $query;
        }

        $search = $filter['q'];

        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', '%'. $search . '%');
        });
    }
    //-------------------------------------------------
    public static function getList($request) : array
    {
//        $list = static::orderBy('created_at', 'desc');

        $rows = config('vaahcms.per_page');

        if ($request->has('rows')) {
            $rows = $request->rows;
        }
        $list = self::getSorted($request->filter);
        $list->trashedFilter($request->filter);
        $list->searchFilter($request->filter);
        $list = $list->paginate($rows);

        $response['success'] = true;
        $response['data'] = $list;
        return $response;

    }
    //-------------------------------------------------
    public static function getContent($id)
    {
        $vias = [
            'mail',
            'sms',
            'push',
            'frontend',
            'backend',
        ];

        $list = [];

        $item = static::find($id);
        if (!$item) {
            return $list;
        }

        foreach ($vias as $via){
            $list[$via] = $item->contents()->where('via', $via)
                ->get();
        }

        return $list;

    }
    //-------------------------------------------------

    public static function itemAction( $request)
    {
        $type = $request->type;
        $id = $request->id;
        $notification = self::withTrashed()->find($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $vias = [
            'mail',
            'sms',
            'push',
            'frontend',
            'backend',
        ];

        foreach ($vias as $via) {
            if ($notification->$via) {
                if ($type === 'trash') {
                    $notification->$via->contents()->where('via', $via)->delete();
                } elseif ($type === 'restore') {
                    if ($notification->withTrashed()) {
                        $notification->$via->contents()->where('via', $via)->restore();
                    }
                }
            }
        }

        NotificationContent::where('vh_notification_id', $notification->id)->delete();

        if ($type === 'trash') {
            $notification->delete();
            $message = 'Record has been deleted';
        } elseif ($type === 'restore') {
            if ($notification->withTrashed()) {
                $notification->restore();
                $message = 'Record has been restored';
            } else {
                $message = 'Record is not soft-deleted and cannot be restored';
            }
        } else {
            return response()->json(['message' => 'Invalid action type'], 400);
        }

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = $message;

        return $response;
    }






    //-------------------------------------------------
    public static function getItem($id,$excluded_columns = [])
    {

        $item = self::where('id', $id)->with(['createdByUser',
            'updatedByUser', 'deletedByUser'])
            ->withTrashed();

        if(!$item)
        {
            $response['success'] = false;
            $response['errors'][] = 'Record not found with ID: '.$id;
            return $response;
        }

        if (!\Auth::user()->hasPermission('can-see-users-contact-details')) {
            $item->exclude(array_merge(['email','alternate_email', 'phone'],$excluded_columns));
        } else {
            $item->exclude($excluded_columns);
        }

        $item = $item->first();

        $response['success'] = true;
        $response['data'] = $item;

        return $response;

    }
    //-------------------------------------------------
    public static function listAction($request)
    {
        $type = $request->type;
        $items = $request->items;
        $notification = new Notification;

        $item_ids = array_column($items, 'id');
        $list = self::query();
        if($request->has('filter')){
            $list->getSorted($request->filter);
            $list->trashedFilter($request->filter);
            $list->searchFilter($request->filter);
        }

        switch ($type) {
            case 'trash':
                self::whereIn('id', $item_ids)->delete();
                break;
            case 'restore':
                self::whereIn('id', $item_ids)->withTrashed()->restore();
                break;
            case 'delete':
                NotificationContent::whereIn('vh_notification_id', $item_ids)->withTrashed()->forceDelete();
                self::whereIn('id', $item_ids)->withTrashed()->forceDelete();
                break;
            case 'trash-all':
                $notification->query()->delete();
                break;
            case 'restore-all':
                $list->restore();
                break;
            case 'delete-all':
                NotificationContent::query()->forceDelete();
                $list->forceDelete();
                break;

        }

        $response['success'] = true;
        $response['data'] = true;
        $response['messages'][] = 'Action was successful.';

        return $response;
    }
    //-------------------------------------------------
    public static function postStore($request)
    {
        $rules = array(
            'name' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];

        $item = static::where('slug', Str::slug($request->name))
            ->first();

        if(!$item)
        {
            $item = new static();
        }

        $inputs = $request->except('content');
        $item->fill($inputs);
        $item->save();

        if(count($request->contents) > 0)
        {
            foreach ($request->contents as $key => $vias)
            {
                if(count($vias) < 1)
                {
                    continue;
                }


                if($key == 'mail'){
                    $list = NotificationContent::where('vh_notification_id', $vias[0]['vh_notification_id'])
                        ->where('via',  'mail')->pluck('id')->toArray();

                    $input_groups = collect($vias)->pluck('id')->toArray();


                    $groups_to_delete = array_diff($list, $input_groups);

                    if(count($groups_to_delete) > 0)
                    {
                        foreach ($groups_to_delete as $id)
                        {
                            NotificationContent::deleteItem($id);
                        }
                    }
                }

                foreach ($vias as $via)
                {

                    $content = null;

                    $content = NotificationContent::where('key', $via['key'])
                        ->where('vh_notification_id', $via['vh_notification_id'])
                        ->where('sort', $via['sort'])
                        ->where('via', $via['via'])->first();

                    if(!$content)
                    {
                        $new_content = new NotificationContent();
                        $new_content->fill($via);
                        $new_content->save();

                    }else{
                        $content->fill($via);
                        $content->save();
                    }

                }

            }
        }


        $response['success'] = true;
        $response['messages'][] = 'Saved';
        $response['data']['item'] = $item;


        return $response;

    }
    //-------------------------------------------------
    public static function dispatch(Notification $notification, User $user, $inputs, $priority='default')
    {

        if(config('settings.global.laravel_queues'))
        {
            $response = self::addInQueue($notification, $user, $inputs, $priority);
        } else
        {
            $response = self::send($notification, $user, $inputs);
        }

        return $response;
    }
    //-------------------------------------------------
    public static function addInQueue(Notification $notification, User $user, $inputs, $priority='default')
    {

        dispatch((new ProcessNotifications($notification, $user, $inputs))
            ->onQueue($priority));

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;

    }
    //-------------------------------------------------
    public static function send(Notification $notification, User $user, $inputs){

        $rules = array(
            'user_id' => 'required',
            'notification_id' => 'required',
        );

        $validator = \Validator::make( $inputs, $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }


        try{

            if($notification->via_mail == true)
            {
                static::sendViaMail($notification, $user, $inputs);
            }

            if($notification->via_backend == true)
            {
                static::sendViaBackend($notification, $user, $inputs);
            }

            if($notification->via_frontend == true)
            {
                static::sendViaFrontend($notification, $user, $inputs);
            }

            $response['success'] = true;
            $response['data'] = [];
            $response['messages'][] = trans('vaahcms-general.action_successful');

        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
        }

        return $response;

    }

    //-------------------------------------------------
    public static function sendViaMail(Notification $notification, User $user, $params=[])
    {
        $user->notify(new Notice($notification, $params));
    }
    //-------------------------------------------------
    public static function sendViaBackend(Notification $notification, User $user, $params=[])
    {

        $translated = static::getTranslatedContent('backend', $notification,  $params);

        if($notification->is_error)
        {
            $translated['is_error'] = true;
        }

        $notify = new Notified();
        $notify->vh_notification_id = $notification->id;
        $notify->vh_user_id = $user->id;
        $notify->via = 'backend';
        $notify->meta = $translated;

        $notify->save();

    }
    //-------------------------------------------------
    public static function sendViaFrontend(Notification $notification, User $user, $params=[])
    {
        $user->notify(new Notice($notification, $params));
    }
    //-------------------------------------------------
    public static function getTranslatedContent($via, Notification $notification, $params=[])
    {

        $contents = $notification->contents()
            ->where('via', $via)
            ->orderBy('sort', 'asc')
            ->get();

        $translated = [];

        if($contents)
        {
            foreach ($contents as $content)
            {

                switch ($content->key)
                {

                    case 'content':
                        $translate = vh_translate_dynamic_strings($content->value, $params);
                        $translated['message'] = $translate;
                        break;

                    case 'action':
                        $translated['action']['label'] = $content->value;
                        $translate = vh_translate_dynamic_strings($content->meta->action, $params);
                        $translated['action']['link'] = $translate;

                        break;
                }
            }
        }

        return $translated;
    }
    //-------------------------------------------------
    public static function mailValidation($inputs){

        $rules = array(
            'value' => 'nullable|email|max:150',
        );

        $messages = array(
            'value.email' => 'The email field must be a valid email address.',
            'value.max' => 'The email may not be greater than 150 characters.',
        );

        $validator = \Validator::make($inputs,$rules,$messages);

        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

    }

    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------


}
