<?php namespace WebReinvent\VaahCms\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class BatchBase extends Model
{
    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'job_batches';
    //-------------------------------------------------
    protected $casts = [
        'cancelled_at' => 'datetime',
        'created_at' => 'datetime',
        'finished_at' => 'datetime'
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



    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);
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
            $from = \Carbon::parse($from)
                ->setTimezone(env('APP_TIMEZONE'))
                ->format('Y-m-d');
        }
        if($to)
        {
            $to = \Carbon::parse($to)
                ->setTimezone(env('APP_TIMEZONE'))
                ->format('Y-m-d');
        }
        $query->whereBetween($by,[$from,$to]);
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public static function getList($request)
    {
        $list = self::orderBy('created_at', 'DESC');

        if(isset($request->filter['from']) && $request->filter['from']
            && isset($request->filter['to']) && $request->filter['to'])
        {
            if(isset($request->filter['date_filter_by']) && $request->filter['date_filter_by']){
                $list->betweenDates($request->filter['from'],$request->filter['to'],$request->filter['date_filter_by']);
            } else {
                $list->betweenDates($request->filter['from'],$request->filter['to']);
            }
        }

        if(isset($request->filter['q']) && $request->filter['q'])
        {
            $list->where(function ($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->filter['q'].'%');
                $q->orWhere('id', 'LIKE', '%'.$request->filter['q'].'%');
            });
        }
        $rows = config('vaahcms.per_page');

        if($request->has('rows'))
        {
            $rows = $request->rows;
        }

        if ($request->has('date_filter_by')) {
            $data['list'] = $list->orderBy($request->filter['date_filter_by'],'desc')->paginate($rows);
        } else {
            $data['list'] = $list->orderBy('created_at','desc')->paginate($rows);
        }


        $response['success'] = true;
        $response['data'] = $data;

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
            $id = (int) $id;
            $item = self::where('id', $id)->first();

            if ($item)
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
    //-------------------------------------------------
    //-------------------------------------------------


}
