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

        if($request->sync){
            LanguageString::syncAndGenerateStrings($request);
        }

        $data = [];

        if(!$request->has('vh_lang_language_id'))
        {
            $lang = Language::where('default', 1)->first();
            $request->merge(['vh_lang_language_id'=>$lang->id]);
        }

        if(!$request->has('vh_lang_category_id'))
        {
            $cat = LanguageCategory::where('slug', 'general')->first();
            $request->merge(['vh_lang_category_id'=>$cat->id]);
        }

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
    public function delete(Request $request)
    {

        $response = LanguageString::deleteItem($request);

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function upload(Request $request)
    {

        /*echo \VaahExcel::helloWorld();
        die("<hr/>line number=123");

        $response = \VaahFile::upload($request);

        echo "<pre>";
        print_r($response);
        echo "</pre>";
        die("<hr/>line number=123");

        return response()->json($response);*/

    } //----------------------------------------------------------
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
