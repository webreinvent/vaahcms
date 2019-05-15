<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;



use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;


class SetupController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_admin_theme();
    }

    //----------------------------------------------------------
    public function index()
    {
        return view($this->theme.'.setup.welcome');
    }

    //----------------------------------------------------------
    public function storeAppInfo(Request $request)
    {
        $rules = array(
            'app_name' => 'required',
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required'
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $inputs = $request->all();
        $inputs['app_key'] = Str::random(44);
        $inputs['app_url'] = url("/");

        if(!isset($inputs['db_password']))
        {
            $inputs['db_password'] = "";
        }

        $env_data = \View::make($this->theme.'.setup.partials.setup-env-sample')
            ->with('data', (object)$inputs)->render();

        \File::put(base_path(".env"), $env_data);

        $response['status'] = 'success';
        $response['messages'][] = 'Details Saved';
        $response['data']['env'] = $env_data;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function runMigrations(Request $request)
    {

        $data = [];



        try
        {

            //publish all migrations of vaahcms package
            $command = 'vendor:publish';
            $params = [
                '--provider' => "WebReinvent\VaahCms\VaahCmsServiceProvider",
                '--tag' => "migrations",
            ];
            \Artisan::call($command, $params);

            //run migration
            $command = 'migrate';
            $params = [
                '--force' => true
            ];
            \Artisan::call($command, $params);

            //publish vaahcms seeds
            $command = 'vendor:publish';
            $params = [
                '--provider' => "WebReinvent\VaahCms\VaahCmsServiceProvider",
                '--tag' => "seeds",
            ];
            \Artisan::call($command, $params);

            //run vaahcms seeds
            $command = 'db:seed';
            $params = [
                '--class' => "VaahCmsTableSeeder"
            ];
            \Artisan::call($command, $params);


            $response['status'] = 'success';
            $response['messages'][] = 'Migration were successful';
            $response['data'] = $data;

            return response()->json($response);

        }
        catch(\Exception $e) {

            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return response()->json($response);
        }





    }

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
