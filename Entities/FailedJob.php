<?php namespace WebReinvent\VaahCms\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class FailedJob extends Model {


    //-------------------------------------------------
    protected $table = 'failed_jobs';
    //-------------------------------------------------
    protected $dates = [
        'failed_at',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $casts = [
        'failed_at'  => 'date:Y-m-d H:i:s',
    ];
    //-------------------------------------------------
    protected $fillable = [
    ];

    //-------------------------------------------------
    protected $appends  = [
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
    public function scopeBetweenDates($query, $from, $to)
    {

        if($from)
        {
            $from = Carbon::parse($from)
                ->startOfDay()
                ->toDateTimeString();
        }
        if($to)
        {
            $to = Carbon::parse($to)
                ->endOfDay()
                ->toDateTimeString();
        }
        $query->whereBetween('failed_at',[$from,$to]);
    }
    //-------------------------------------------------
    public static function getList($request)
    {

        $list = self::orderBy('id', 'desc');

        if(isset($request->from) && $request->from
            && isset($request->to) && $request->to){

            $list->betweenDates($request['from'],$request['to']);

        }

        if(isset($request->q) && $request->q)
        {
            $list->where(function ($q) use ($request){
                $q->where('queue', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('connection', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('id', 'LIKE', '%'.$request->q.'%');
            });
        }

        $data['list'] = $list->paginate(config('vaahcms.per_page'));

        $response['status'] = 'success';
        $response['data'] = $data;

        return $response;
    }
    //-------------------------------------------------
    public static function getItem($id)
    {
        $item = self::where('id', $id)
        ->first();
        $response['status'] = 'success';
        $response['data'] = $item;

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


}
