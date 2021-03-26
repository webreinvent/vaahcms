<?php namespace WebReinvent\VaahCms\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Jobs\ProcessNotifications;
use WebReinvent\VaahCms\Notifications\Notice;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;

class Notification extends Model {

    use SoftDeletes;
    use CrudWithUuidObservantTrait;

    //-------------------------------------------------
    protected $table = 'vh_notifications';
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

    protected $casts = [
        "created_at" => 'date:Y-m-d H:i:s',
        "updated_at" => 'date:Y-m-d H:i:s',
        "deleted_at" => 'date:Y-m-d H:i:s'
    ];
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
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
            'created_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }
    //-------------------------------------------------
    public function updatedByUser()
    {
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
            'updated_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
    }
    //-------------------------------------------------
    public function deletedByUser()
    {
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
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
    public static function getList($request)
    {
        $list = static::orderBy('name')->get();
        return $list;
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

        foreach ($vias as $via){
            $list[$via] = $item->contents()->where('via', $via)
                ->get();
        }

        return $list;

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
            $response['status'] = 'failed';
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

                    if(!isset($via['value'])
                        || is_null($via['value']) || empty($via['value']))
                    {
                        continue;
                    }

                    if($via['key'] == 'from'){
                        $validation = self::mailValidation($via);
                        if(isset($validation['status'])
                            && $validation['status'] == 'failed')
                        {
                            return $validation;
                        }
                    }

                    $content = null;

                    $content = NotificationContent::where('key', $via['key'])
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


        $response['status'] = 'success';
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

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

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
            $response['status'] = 'failed';
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

            $response['status'] = 'success';
            $response['data'] = [];
            $response['messages'][] = 'Action was successful';

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
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
    public static function getTranslatedContent($vai, Notification $notification, $params=[])
    {

        $contents = $notification->contents()
            ->where('via', $vai)
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
                        $translate = vh_translate_dynamic_strings($content->meta->action, []);
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
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

    }

    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------


}
