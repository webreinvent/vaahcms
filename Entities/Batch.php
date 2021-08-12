<?php namespace WebReinvent\VaahCms\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Batch extends Model {

    //-------------------------------------------------
    protected $table = 'job_batches';
    //-------------------------------------------------
    protected $dates = [
        'cancelled_at',
        'created_at',
        'finished_at'
    ];
    //-------------------------------------------------
    protected $casts = [
        'cancelled_at'  => 'date:Y-m-d H:i:s',
        'created_at'  => 'date:Y-m-d H:i:s',
        'finished_at'  => 'date:Y-m-d H:i:s',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
    ];

    //-------------------------------------------------
    protected $appends  = [
        'count_failed_jobs'
    ];
    //-------------------------------------------------

    public function __construct(array $attributes = [])
    {
        $date_time_format = config('settings.global.datetime_format');
        if(is_array($this->casts) && isset($date_time_format))
        {
            foreach ($this->casts as $date_key => $format)
            {
                $this->casts[$date_key] = 'date:'.$date_time_format;
            }
        }
        parent::__construct($attributes);
    }

    //-------------------------------------------------

    public function getFailedJobIdsAttribute($value)
    {
        if($value)
        {
            $value = json_decode($value, true);
        }
        return $value;
    }
    //-------------------------------------------------
    public function getCountFailedJobsAttribute()
    {
        $value = 0;

        if(
            isset($this->failed_job_ids)
            && !empty($this->failed_job_ids)
            && is_array($this->failed_job_ids)
        ){
            $value = count($this->failed_job_ids);
        }

        return $value;
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
    public function scopeBetweenDates($query, $from, $to,$by = 'created_at')
    {

        if($from)
        {
            $from = Carbon::parse($from)->timestamp;
        }
        if($to)
        {
            $to = Carbon::parse($to)->timestamp;
        }
        $query->whereBetween($by,[$from,$to]);
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public static function getList($request)
    {


        $list = self::orderBy('created_at', 'DESC');

        if($request['trashed'] == 'true')
        {

            $list->withTrashed();
        }

        if(isset($request->from) && $request->from
            && isset($request->to) && $request->to)
        {
            if(isset($request->date_filter_by) && $request->date_filter_by){
                $list->betweenDates($request['from'],$request['to'],$request->date_filter_by);
            }else{
                $list->betweenDates($request['from'],$request['to']);
            }
        }


        if(isset($request->q) && $request->q)
        {
            $list->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->q.'%');
                $q->orWhere('id', 'LIKE', '%'.$request->q.'%');
            });
        }


        $data['list'] = $list->paginate(config('vaahcms.per_page'));

        $response['status'] = 'success';
        $response['data'] = $data;

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
            $item = self::where('id', $id)->first();
            if($item)
            {
                $item->delete();
            }
        }

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------
    public static function bulkDeleteAll($request)
    {

        self::truncate();

        $response['status'] = 'success';
        $response['data'] = [];
        $response['messages'][] = 'Action was successful';

        return $response;


    }
    //-------------------------------------------------

    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------


}
