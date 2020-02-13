<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Language;
use WebReinvent\VaahCms\Entities\LanguageCategory;
use WebReinvent\VaahCms\Entities\LanguageString;


class LocalizationController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_admin_theme();
    }

    //----------------------------------------------------------
    public function getAssets(Request $request)
    {
        $data = [];
        $response['status'] = 'success';
        $response['data']['languages']['list'] = Language::orderBy('default','desc')
            ->get();
        $response['data']['languages']['default'] = Language::where('default',1)
            ->first();


        $response['data']['categories']['list'] = LanguageCategory::orderBy('name','asc')
            ->get();
        $response['data']['categories']['default'] = LanguageCategory::where('slug','general')
            ->first();

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {


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
    public function store(Request $request)
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
    public function sync(Request $request)
    {

        LanguageString::syncStrings($request);

        $response = LanguageString::getList($request);

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
