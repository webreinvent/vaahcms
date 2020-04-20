<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use WebReinvent\VaahCms\Entities\Language;
use WebReinvent\VaahCms\Entities\LanguageCategory;
use WebReinvent\VaahCms\Entities\LanguageString;


class LocalizationController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }

    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        $lang_list = Language::getLangList();

        $response['status'] = 'success';
        $response['data']['languages']['list'] = $lang_list;

        $response['data']['languages']['default'] = Language::where('default',1)
            ->first();


        $response['data']['categories']['list'] = LanguageCategory::orderBy('name','asc')
            ->get();
        $response['data']['categories']['default']['id'] = null;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = LanguageString::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postStore(Request $request,$id)
    {
        $response = LanguageString::storeList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeLanguage(Request $request)
    {

        $response = Language::store($request);

        LanguageString::syncStrings($request);

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function storeCategory(Request $request)
    {

        $response = LanguageCategory::store($request);

        LanguageString::syncStrings($request);

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {

        switch ($action)
        {

            //------------------------------------
            case 'delete-language-string':

                $response = LanguageString::deleteItem($request);

                break;

            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
