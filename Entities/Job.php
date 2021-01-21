<?php namespace WebReinvent\VaahCms\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Job extends Model {


    //-------------------------------------------------
    protected $table = 'jobs';
    //-------------------------------------------------
    protected $dates = [
        'reserved_at',
        'available_at',
        'created_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $casts = [
        'reserved_at'  => 'date:Y-m-d H:i:s',
        'available_at'  => 'date:Y-m-d H:i:s',
        'created_at'  => 'date:Y-m-d H:i:s',
    ];
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
            $from = \Illuminate\Support\Carbon::parse($from)
                ->startOfDay()
                ->toDateTimeString();
        }
        if($to)
        {
            $to = Carbon::parse($to)
                ->endOfDay()
                ->toDateTimeString();
        }
        $query->whereBetween('created_at',[$from,$to]);
    }
    //-------------------------------------------------
    public static function getList($request)
    {

        $list = self::orderBy('id', 'desc');

        if(isset($request->from) && $request->from
            && isset($request->to) && $request->to)
        {
            $from = Carbon::parse($request->from)->timestamp;
            $to = Carbon::parse($request->to)->timestamp;

            if(isset($request->date_filter_by) && $request->date_filter_by){
                $list->whereBetween( $request->date_filter_by, [$from, $to]);
            }else{
                $list->whereBetween( 'created_at', [$from, $to]);
            }
        }

        if(isset($request->q))
        {
            $list->where(function ($q) use ($request){
                $q->where('queue', 'LIKE', '%'.$request->q.'%');
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
    //-------------------------------------------------
    //-------------------------------------------------


}
