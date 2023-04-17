<?php namespace WebReinvent\VaahCms\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class JobBase extends Model
{
    //-------------------------------------------------
    protected $table = 'jobs';
    //-------------------------------------------------
    protected $casts = [
        'reserved_at' => 'datetime',
        'available_at' => 'datetime',
        'created_at' => 'datetime',
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


    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

    }
    //-------------------------------------------------
    public function getPayloadAttribute($value)
    {
        return json_decode($value);
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
    public static function getList($request)
    {

        $list = self::orderBy('id', 'desc');

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
                $q->where('queue', 'LIKE', '%'.$request->q.'%');
                $q->orWhere('id', 'LIKE', '%'.$request->q.'%');
            });
        }

        if(isset($request->status) && $request->status)
        {
            $list->where('queue', $request->status);
        }

        $data['list'] = $list->paginate(config('vaahcms.per_page'));

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


}
