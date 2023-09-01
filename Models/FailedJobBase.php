<?php namespace WebReinvent\VaahCms\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class FailedJobBase extends Model {


    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'failed_jobs';
    //-------------------------------------------------
    protected $casts = [
        'failed_at'  => 'datetime',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    //-------------------------------------------------
    protected $fillable = [
    ];

    //-------------------------------------------------
    protected $appends  = [
    ];

    //-------------------------------------------------
    public function getPayloadAttribute($value)
    {
        return json_decode($value);
    }

    //-------------------------------------------------
    public function getExceptionAttribute($value)
    {
        return json_decode($value);
    }
    //-------------------------------------------------
    public static function getList($request)
    {

        $list = self::orderBy('id', 'desc');

        if(isset($request->from) && $request->from
            && isset($request->to) && $request->to){

            $list->betweenDates($request['from'],$request['to']);

        }

        if(isset($request->filter['q']) && $request->filter['q'])
        {
            $list->where(function ($q) use ($request){
                $q->where('queue', 'LIKE', '%'.$request->filter['q'].'%')
                    ->orWhere('connection', 'LIKE', '%'.$request->filter['q'].'%')
                    ->orWhere('id', 'LIKE', '%'.$request->filter['q'].'%');
            });
        }

        $rows = config('vaahcms.per_page');

        if($request->has('rows'))
        {
            $rows = $request->rows;
        }

        $data['list'] = $list->paginate($rows);

        $response['success'] = true;
        $response['data'] = $data;

        return $response;
    }
    //-------------------------------------------------
    public static function getItem($id)
    {
        $item = self::where('id', $id)
        ->first();
        $response['success'] = true;
        $response['data'] = $item;

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
            $item = self::where('id', $id)->first();
            if($item)
            {
                $item->delete();
            }
        }

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------

    //-------------------------------------------------
    public static function bulkDeleteAll($request)
    {

        self::truncate();

        $response['success'] = true;
        $response['data'] = [];
        $response['messages'][] = trans('vaahcms-general.action_successful');

        return $response;


    }
    //-------------------------------------------------
    //-------------------------------------------------


}
