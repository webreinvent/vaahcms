<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Entities\Registration;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\User;

class RegistrationsController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $list = Registration::orderBy('created_at', 'DESC');

        if($request->has('trashed') && $request->trashed == 'true')
        {
            $list->withTrashed();
        }

        if(isset($request->from) && isset($request->to))
        {
            $list->betweenDates($request['from'],$request['to']);
        }

        if($request->has('status') && !empty( $request->status))
        {
            $list->where('status', $request->status);
        }

        if($request->has("q"))
        {
            $list->where(function ($q) use ($request){
                $q->where('first_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('display_name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere(\DB::raw('concat(first_name," ",middle_name," ",last_name)'), 'like', '%'.$request['q'].'%')
                    ->orWhere(\DB::raw('concat(first_name," ",last_name)'), 'like', '%'.$request['q'].'%')
                    ->orWhere('email', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('id', '=', $request->q);
            });
        }

        if(isset($request['per_page'])
            && $request['per_page']
            && is_numeric($request['per_page'])){
            $list = $list->paginate($request['per_page']);
        }else{
            $list = $list->paginate(config('vaahcms.per_page'));
        }

        $response['status'] = 'success';
        $response['data']['list'] = $list;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $column, $value)
    {
        $item = Registration::where($column, $value)->with(['createdByUser',
            'updatedByUser', 'deletedByUser'])
            ->withTrashed()->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'Registration not found.';
            return $response;
        }

        $response['status'] = 'success';
        $response['data'] = $item;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createUser(Request $request, $column, $value)
    {

        $item = Registration::withTrashed()->where($column, $value)->first();

        if(!$item){
            $response['status']     = 'failed';
            $response['errors']     = 'Registration not found.';
            return $response;
        }

        $response = Registration::createUser($item->id);
        return response()->json($response);

    }


}
