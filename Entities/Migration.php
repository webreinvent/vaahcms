<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;

class Migration extends Model {

    //-------------------------------------------------
    protected $table = 'vh_migrations';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'migrationable_id',
        'migrationable_type',
        'migration_id',
        'batch'
    ];

    //-------------------------------------------------

    protected $casts = [
        "created_at" => 'date:Y-m-d H:i:s',
        "updated_at" => 'date:Y-m-d H:i:s',
        "deleted_at" => 'date:Y-m-d H:i:s'
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
    public function migrationable()
    {
        return $this->morphTo();
    }
    //-------------------------------------------------
    public static function syncModuleMigrations($module_id=null)
    {
        $migrations = \DB::table('migrations')->count();

        if($migrations < 1)
        {
            return false;
        }

        /*
         * Ignoring batch 1 because this will be setup batch for vaahcms
         */
        $migrations = \DB::table('migrations')
            ->where('batch', '!=', 1)
            ->get();

        $module = Module::find($module_id);

        foreach ($migrations as $migration_input)
        {

            $migration_data = [];
            $migration_data['migration_id'] = $migration_input->id;
            $migration_data['batch'] = $migration_input->batch;

            $migration = new Migration($migration_data);

            $module->migrations()->save($migration);

        }


        return true;
    }
    //-------------------------------------------------
    public static function syncThemeMigrations($theme_id=null)
    {
        $migrations = \DB::table('migrations')->count();

        if($migrations < 1)
        {
            return false;
        }

        /*
         * Ignoring batch 1 because this will be setup batch for vaahcms
         */
        $migrations = \DB::table('migrations')
            ->where('batch', '!=', 1)
            ->get();

        $theme = Theme::find($theme_id);

        foreach ($migrations as $migration_input)
        {

            $migration_data = [];
            $migration_data['migration_id'] = $migration_input->id;
            $migration_data['batch'] = $migration_input->batch;

            $migration = new Migration($migration_data);

            $theme->migrations()->save($migration);

        }


        return true;
    }
    //-------------------------------------------------
    public static function runMigrations($path=null, $force=false)
    {
        //run migration
        $command = 'migrate';

        $params = [
            '--force' => true,
            '--quiet' => true,
        ];
        if($path)
        {
            $params['--path'] = $path;
        }


        \Artisan::call($command, $params);
    }
    //-------------------------------------------------
    public static function runSeeds($namespace=null)
    {
        $command = 'db:seed';

        $params = [
            '--force' => true,
            '--quiet' => true,
        ];

        if($namespace)
        {
            $params['--class'] = $namespace;
        }
        \Artisan::call($command, $params);
    }
    //-------------------------------------------------
    public static function resetMigrations()
    {
        $command = 'migrate:reset';
        $params = [
            '--force' => true,
            '--quiet' => true,
        ];
        \Artisan::call($command, $params);
    }
    //-------------------------------------------------
    public static function publishMigrations($provider)
    {
        $command = 'vendor:publish';
        $params = [
            '--provider' => $provider,
            '--tag' => "migrations",
            '--force' => true,
            '--quiet' => true,
        ];
        \Artisan::call($command, $params);
    }
    //-------------------------------------------------
    public static function publishSeeds($provider)
    {
        $command = 'vendor:publish';
        $params = [
            '--provider' => $provider,
            '--tag' => "seeds",
            '--force' => true,
            '--quiet' => true,
        ];
        \Artisan::call($command, $params);
    }
    //-------------------------------------------------
    public static function publishAssets($provider)
    {

        try{

            $command = 'vendor:publish';
            $params = [
                '--provider' => $provider,
                '--tag' => "assets",
                '--force' => true
            ];

            \Artisan::call($command, $params);

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['messages'][] = $e->getMessage();
            return $response;
        }


    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------

}
