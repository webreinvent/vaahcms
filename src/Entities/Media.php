<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Traits\CrudObservantTrait;


class Media extends Model {

    use SoftDeletes;
    use CrudObservantTrait;
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
        'slug',
        'mime_type',
        'path',
        'url',
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
    protected $appends  = [

    ];
    //-------------------------------------------------
    public function scopeSlug( $query, $slug ) {
        return $query->where( 'slug', $slug );
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public function createdByUser()
    {
        return $this->belongsTo('WebReinvent\VaahCms\Entities\User',
            'created_by', 'id'
        )->select('id', 'uuid', 'first_name', 'last_name', 'email');
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

        $data['list'] = $list->paginate(config('vaahcms.per_page'));


        $response['status'] = 'success';
        $response['data'] = $data;

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

        $data['list'] = $list->paginate(config('vaahcms.per_page'));


        $response['status'] = 'success';
        $response['data'] = $data;

        return $response;
    }

    //-------------------------------------------------

    public static function getDetail($id)
    {

        $item = Permission::where('id', $id)->with(['createdByUser', 'updatedByUser', 'deletedByUser'])
            ->withTrashed()->first();

        $response['status'] = 'success';
        $response['data'] = $item;

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
