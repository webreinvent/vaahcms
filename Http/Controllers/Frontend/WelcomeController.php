<?php

namespace WebReinvent\VaahCms\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use VaahCms\Modules\Cms\Entities\MenuItem;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\Theme;
use WebReinvent\VaahCms\Models\User;
use WebReinvent\VaahExtend\Libraries\VaahArtisan;
use Faker\Factory;
use WebReinvent\VaahExtend\Libraries\VaahDB;

class WelcomeController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function clearCache(Request $request)
    {
        $response = VaahArtisan::clearCache();
        if(isset($response['success']) && !$response['success'])
        {
            return $response;
        }

        try{
            $files = ['config.php', 'packages.php', 'services.php'];
            $path = base_path().'/bootstrap/cache/';
            foreach ($files as $file)
            {
                if(\File::exists($path.$file))
                {
                    \File::delete($path.$file);
                }
            }

            $response['success'] = true;
            $response['messages'][] = 'Cache was successfully deleted.';

        }catch(\Exception $e)
        {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();

        }

        return $response;

    }
    //----------------------------------------------------------
    public function index(Request $request)
    {

        if(app()->runningInConsole())
        {
            return true;
        }

        $errors = [];

        $message = 'Install VaahCMS and activate the CMS module or define your own routes.';

        if(!VaahDB::isConnected())
        {
            $errors[] = $message;
            return view($request->theme_slug.'::frontend.welcome')->withErrors($errors);
        }

        if(!VaahDB::isTableExist('vh_modules'))
        {
            $errors[] = $message;
            return view($request->theme_slug.'::frontend.welcome')->withErrors($errors);
        }

        $is_cms_exists = Module::slug('cms')->active()->exists();

        if(!$is_cms_exists)
        {
            $errors[] = $message;
            return view($request->theme_slug.'::frontend.welcome')->withErrors($errors);
        }

        $is_theme_active = Theme::active()->exists();

        if(!$is_theme_active)
        {
            $errors[] = 'Install a theme and activate it.';
            return view($this->theme.'::frontend.welcome')->withErrors($errors);
        }

        $is_theme_active = Theme::active()->count();

        //if CMS module is not installed or active
        if($is_theme_active < 1)
        {
            $errors[] = 'No theme is marked as active.';
            return view($this->theme.'::frontend.welcome')->withErrors($errors);
        }

        $menu_item = MenuItem::getHomePage();

        if(!$menu_item)
        {
            //if dedicated welcome files does not exist in activated theme
            if (!view()->exists($this->theme.'::frontend.welcome')) {
                $errors[] = 'Activated theme does not have any welcome (frontend/welcome.blade.php) file.';
                $errors[] = 'Please read theme documentation.';
                return view(config('vaahcms.backend_theme').'::frontend.theme-welcome')
                    ->withErrors($errors);
            }

            return view($this->theme.'::frontend.welcome');
        }

        $blade = $menu_item->content->theme->slug.'::'.$menu_item->content->template->file_path;

        return view($blade)->with('data', $menu_item->content);
    }

    //----------------------------------------------------------
    public function getFaker(Request $request)
    {

        $rules = array(
            'model_namespace' => 'required',
        );

        $messages = [
            'model_namespace.required' => "model_namespace is required. Eg: WebReinvent\VaahCms\Models\User"
        ];

        $validator = \Validator::make( $request->all(), $rules, $messages);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        $model = $request->model_namespace;

        $model = new $model();

        $table = $model->getTable();

        if($request->filled('fillable'))
        {
            $fillable = $request->fillable;
        } else{
            $fillable = $model->getFillable();
        }

        if($request->filled('except'))
        {
            $except = $request->except;
            $fillable = array_diff($fillable,$except);
        };

        $faker = Factory::create();

        $fill = [];
        $list = [];

        $i = 0;
        foreach ($fillable as $column)
        {
            $type = \DB::getSchemaBuilder()->getColumnType($table, $column);

            $value = null;

            switch($type)
            {

                case 'text':
                $value = $faker->text(60);
                    break;

                case 'string':
                    $value = $faker->text(25);
                    break;

                case 'boolean':
                    $value = array_rand([0,1]);
                    break;



            }

            $list[$i]['column'] = $column;
            $list[$i]['type'] = $type;
            $list[$i]['value'] = $value;
            $fill[$column] = $value;
            $i++;

        }


        foreach ($fill as $column => $value)
        {
            switch ($column){

                case 'first_name':
                    $fill[$column] = $faker->firstName;
                    break;

                case 'last_name':
                case 'middle_name':
                    $fill[$column] = $faker->lastName;
                    break;

                case 'alternate_email':
                case 'email':
                    $fill[$column] = $faker->email;
                    break;

                case 'password':
                    $fill[$column] = $faker->password;
                break;

                case 'country_calling_code':
                    $fill[$column] = $faker->randomElement([91]);
                    break;

                case 'gender':
                    $fill[$column] = $faker->randomElement(['m','f','o']);
                    break;


                case 'timezone':
                    $fill[$column] = $faker->timezone('US');
                break;

                case 'display_name':
                case 'username':
                    $fill[$column] = $faker->userName;
                    break;


                case 'slug':
                    if(isset($fill['name']) && !empty($fill['name']))
                    {
                        $fill[$column] = Str::slug($fill['name']);
                    }
                    break;

                case 'created_by':
                case 'updated_by':
                    $fill[$column] = User::inRandomOrder()->first()->id;
                    break;

            }
        }


        $data['fill']=$fill;
        $data['list']=$list;

        $response['success'] = true;
        $response['data'] = $data;
        return $response;


    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
