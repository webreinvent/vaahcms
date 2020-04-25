<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudWithUuidObservantTrait;


class Media extends Model {

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
        'type', 'size_for_humans'
    ];
    //-------------------------------------------------
    public function getDownloadUrlAttribute($value) {
        return route('vh.frontend.media.download',[$value]);
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
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
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
            $response['status'] = 'failed';
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
                $response['status'] = 'failed';
                $response['errors'][] = 'Download url is associated with other media.';
                return $response;
            }
        }


        $item = new Media();
        $item->fill($request->all());
        $item->save();

        $response['status'] = 'success';
        $response['data'] = $item;

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

        if(isset($request->q))
        {
            $list->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
            });
        }

        $list->whereNull('is_hidden');

        $data['list'] = $list->paginate(config('vaahcms.per_page'));


        $response['status'] = 'success';
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
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $item = static::where('id', $request->id);
        $item->withTrashed();
        $item->with(['createdByUser', 'updatedByUser', 'deletedByUser']);
        $item = $item->first();

        $response['status'] = 'success';
        $response['data']['item'] = $item;

        return $response;

    }

    //-------------------------------------------------

    //-------------------------------------------------
    public static function updateDetail($request,$id)
    {

        $input = $request->item;


        $validation = static::validation($input);
        if(isset($validation['status']) && $validation['status'] == 'failed')
        {
            return $validation;
        }

        $update = static::where('id',$id)->withTrashed()->first();

        $update->name = $input['name'];
        $update->details = $input['details'];
        $update->is_active = $input['is_active'];

        $update->save();


        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Data updated.';

        return $response;

    }

    //-------------------------------------------------
    public static function bulkStatusChange($request)
    {


        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $perm = static::where('id',$id)->withTrashed()->first();

            if($perm->deleted_at){
                continue ;
            }

            if($request['data']){
                $perm->is_active = $request['data']['status'];
            }else{
                if($perm->is_active == 1){
                    $perm->is_active = 0;
                }else{
                    $perm->is_active = 1;
                }
            }
            $perm->save();
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;
    }
    //-------------------------------------------------
    public static function bulkDelete($request)
    {



        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $item = static::where('id', $id)->withTrashed()->first();
            if($item)
            {

                //delete relationship

                $item->forceDelete();

            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }

    //-------------------------------------------------
    public static function bulkTrash($request)
    {

        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }


        foreach($request->inputs as $id)
        {
            $permission = static::withTrashed()->where('id', $id)->first();
            if($permission)
            {
                $permission->is_active = 0;
                $permission->save();
                $permission->delete();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function bulkRestore($request)
    {



        if(!$request->has('inputs'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select IDs';
            return $response;
        }

        if(!$request->has('data'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Select Status';
            return $response;
        }

        foreach($request->inputs as $id)
        {
            $item = static::withTrashed()->where('id', $id)->first();
            if(isset($item) && isset($item->deleted_at))
            {
                $item->restore();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;

    }

    //-------------------------------------------------
    //-------------------------------------------------
}
