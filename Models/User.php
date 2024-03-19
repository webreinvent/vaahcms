<?php
namespace WebReinvent\VaahCms\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class User extends UserBase
{

    //-------------------------------------------------
    protected $connection= 'mysql';
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
    protected function birth(): Attribute
    {
        return Attribute::make(
            set: function (string $value = null) {
                if(!$value){
                    return null;
                }
                return Carbon::parse($value)
                    ->setTimezone(\Auth::user()->timezone)->format('Y-m-d');
            },
        );
    }

    //-------------------------------------------------
    public function getNameAttribute() {

        if($this->display_name)
        {
            return $this->display_name;
        }

        $name = $this->first_name;

        if($this->middle_name)
        {
            $name .= " ".$this->middle_name;
        }

        if($this->last_name)
        {
            $name .= " ".$this->last_name;
        }

        return $name;
    }
    //-------------------------------------------------
    public function scopeExclude($query, $columns)
    {
        return $query->select(array_diff($this->getTableColumns(), $columns));
    }
    //-------------------------------------------------
    public function getMetaAttribute($value)
    {
        if($value && $value!='null'){
            $meta_data = json_decode($value);
        }else{
            $meta_data = json_decode('{}');
        }

        return $this->setCustomFieldsInMeta($meta_data);

    }
    //-------------------------------------------------
    public function setCustomFieldsInMeta($meta_data)
    {
        if(!is_array($meta_data)){
            $meta_data = (array) $meta_data;
        }

        if(!isset($meta_data['custom_fields'])){
            $meta_data['custom_fields'] = [];
        }

        $meta_data['custom_fields'] = (array) $meta_data['custom_fields'];

        $custom_fields = Setting::query()->where('category','user_setting')
            ->where('label','custom_fields')->first();


        if ($custom_fields) {
            foreach ($custom_fields['value'] as $custom_field) {

                if(!isset($meta_data['custom_fields'][$custom_field->slug])){
                    $meta_data['custom_fields'][$custom_field->slug] = null;
                }

            }
        }

        return $meta_data;

    }
    //-------------------------------------------------
    public static function updateList($request)
    {

        $inputs = $request->all();

        $rules = array(
            'type' => 'required',
        );

        $messages = array(
            'type.required' => trans('vaahcms-general.action_type_is_required'),
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

        foreach($items_id as $key => $id) {

            $is_restricted = self::restrictedActions($inputs['type'], $id);

            if(isset($is_restricted['success']) && !$is_restricted['success'])
            {
                $response['errors'][] = '<b>'.$inputs['items'][$key]['email'].'</b>: '.$is_restricted['errors'][0];
                unset($items_id[$key]);
            }

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

        if(!isset($response['errors']) ||
            (count($inputs['items']) !== count($response['errors']))){

            $response['messages'][] = trans('vaahcms-general.action_successful');

        }

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
            'type.required' => trans('vaahcms-general.action_type_is_required'),
            'items.required' => trans('vaahcms-general.select_items'),
        );

        $validator = \Validator::make($inputs, $rules, $messages);
        if ($validator->fails()) {

            $errors = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }
        $response['errors'] = [];
        foreach($inputs['items'] as $item) {

            $is_restricted = self::restrictedActions('delete', $item['id']);

            if(isset($is_restricted['success']) && !$is_restricted['success'])
            {
                $response['errors'][] = '<b>'.$item['email'].'</b>: '.$is_restricted['errors'][0];
                continue;
            }

            $item = self::query()->where('id', $item['id'])->withTrashed()->first();

            if ($item) {
                $item->roles()->detach();
                $item->forceDelete();
            }
        }

        $response['success'] = true;
        $response['data'] = true;

        if(count($inputs['items']) !== count($response['errors'])){

            $response['messages'][] = trans('vaahcms-general.action_successful');

        }

        return $response;
    }
    //-------------------------------------------------
    public static function listAction($request, $type): array
    {
        $response = [];
        $inputs = $request->all();

        $list = self::getSorted($inputs['query']['filter']);
        $list->isActiveFilter($inputs['query']['filter']);
        $list->trashedFilter($inputs['query']['filter']);
        $list->searchFilter($inputs['query']['filter']);

        if (isset($request['from']) && isset($request['to'])) {
            $list->betweenDates($request['from'],$request['to']);
        }

        $list_array = $list->get()->toArray();

        foreach($list_array as $item){
            $is_restricted = self::restrictedActions($type, $item['id']);

            if(isset($is_restricted['success']) && !$is_restricted['success'])
            {
                $response['errors'][] = '<b>'.$item['email'].'</b>: '.$is_restricted['errors'][0];
                $list->where('id','!=',$item['id']);
            }
        }

        switch ($type) {
            case 'activate-all':
                $list->update(['is_active' => 1]);
                break;
            case 'deactivate-all':
                $list->update(['is_active' => null]);
                break;
            case 'trash-all':
                $list->delete();
                break;
            case 'restore-all':
                $list->withTrashed()->restore();
                break;
            case 'delete-all':
                \DB::statement('SET FOREIGN_KEY_CHECKS=0');
                $list->withTrashed()->forceDelete();
                \DB::statement('SET FOREIGN_KEY_CHECKS=1');
                break;
        }

        $response['success'] = true;
        $response['data'] = true;

        if(!isset($response['errors']) ||
            (count($list_array) !== count($response['errors']))){

            $response['messages'][] = trans('vaahcms-general.action_successful');

        }

        return $response;
    }
    //-------------------------------------------------
    public static function updateItem($request)
    {
        $inputs = $request->all();

        $validate = self::validation($inputs);

        if(isset($validate['success']) && !$validate['success'])
        {
            return $validate;
        }

        if(isset($inputs['phone']))
        {
            $rules['phone'] = 'integer';

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success']  = false;
                $response['errors'] = $errors;
                return $response;
            }
        }

        if($request->has('id'))
        {

            // check if already exist
            $user = self::where('id', '!=', $inputs['id'])
                ->where('email',$inputs['email'])->withTrashed()->first();

            if ($user) {
                $response['success']  = false;
                $response['errors'][] = trans('vaahcms-user.email_already_registered');
                return $response;
            }

            // check if already exist
            $user = self::where('id', '!=', $inputs['id'])
                ->where('username',$inputs['username'])->withTrashed()->first();

            if($user)
            {
                $response['success']  = false;
                $response['errors'][] = trans('vaahcms-user.username_already_registered');
                return $response;
            }

            $item = User::withTrashed()->find($request->id);
        } else
        {
            $validation = self::userValidation($request);
            if(isset($validation['status']) && $validation['status'] == 'failed')
            {
                return $validation;
            } else if(isset($validation['status'])
                && $validation['status'] == 'registration-exist')
            {
                $item = $validation['data'];
            } else
            {
                $item = new User();
                $item->password = generate_password();
                $item->is_active = 1;
                $item->status = 'active';
                $item->activated_at = date('Y-m-d H:i:s');
                $item->uuid = Str::uuid();
            }
        }
        if($inputs['is_active'] == '1'){
            $inputs['is_active'] = 1;
        }else{
            $inputs['is_active'] = 0;
        }

        $item->fill($inputs);
        if($request->has('password'))
        {
            $item->password = $request->password;
        }

        $item->save();

        if(!$request->has('id'))
        {
            Role::syncRolesWithUsers();
        }


        $response['success'] = true;
        $response['messages'][] = trans('vaahcms-general.saved');
        $response['data'] = $item;

        return $response;
    }
    //-------------------------------------------------
    public static function deleteItem($request, $id): array
    {
        $item = self::where('id', $id)->withTrashed()->first();
        if (!$item) {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-general.record_does_not_exist');
            return $response;
        }

        $item->roles()->detach();
        $item->forceDelete();

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.record_has_been_deleted');

        return $response;
    }
    //-------------------------------------------------
    public static function itemAction($request, $id, $type): array
    {
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
                self::where('id', $id)
                    ->withTrashed()
                    ->delete();
                $item = self::where('id',$id)->withTrashed()->first();
                $item->deleted_by = auth()->user()->id;
                $item->save();
                break;
            case 'restore':
                self::where('id', $id)
                    ->withTrashed()
                    ->restore();
                break;
            case 'generate-new-token':

                $token = Str::random(60);


                self::where('id', $id)
                    ->withTrashed()
                    ->update(['api_token' => hash('sha256', $token)]);
                break;
        }

        return self::getItem($id);
    }
    //-------------------------------------------------

    public static function validation($inputs)
    {
        $rules = array(

            'email' => 'required|email|max:150',
            'first_name' => 'required|max:150',
            'status' => 'required',
            'is_active' => 'required',
            'foreign_user_id' => 'nullable|numeric|min:1',

        );


        if(isset($inputs['username']))
        {
            $rules['username'] = 'required';
        }

        $validator = \Validator::make($inputs,$rules);

        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success']  = false;
            $response['errors'] = $errors;
            return $response;
        }

    }

    //-------------------------------------------------
    public static function getActiveItems()
    {
        $item = self::where('is_active', 1)
            ->first();
        return $item;
    }

    //-------------------------------------------------
    public static function create($request)
    {
        $inputs = $request->all();

        $validate = self::validation($inputs);

        if (isset($validate['success']) && !$validate['success']) {
            return $validate;
        }

        $rules = array(
            'password' => 'required',
        );

        $validator = \Validator::make( $inputs, $rules);

        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        // check if already exist
        $user = self::withTrashed()->where('email',$inputs['email'])->first();

        if ($user) {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.email_already_registered');
            return $response;
        }

        // check if username already exist
        $user = self::withTrashed()->where('username',$inputs['username'])->first();

        if ($user) {
            $response['success'] = false;
            $response['errors'][] = trans('vaahcms-user.username_already_registered');
            return $response;
        }

        if (!isset($inputs['username'])) {
            $inputs['username'] = Str::slug($inputs['email']);
        }

        if ($inputs['is_active'] === '1' || $inputs['is_active'] === 1 ) {
            $inputs['is_active'] = 1;
        } else {
            $inputs['is_active'] = 0;
        }

        $inputs['created_ip'] = request()->ip();

        $reg = new static();
        $reg->fill($inputs);
        $reg->save();

        Role::syncRolesWithUsers();

        $response['success'] = true;
        $response['data']['item'] = $reg;
        $response['messages'][] = trans('vaahcms-general.saved_successfully');
        return $response;

    }
    //-------------------------------------------------
    //-------------------------------------------------


}
