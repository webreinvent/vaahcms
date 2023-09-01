<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use WebReinvent\VaahCms\Models\Theme;

class Migration extends Model {

    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_migrations';
    //-------------------------------------------------
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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



    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

    }

    //-------------------------------------------------
    public function migrationable()
    {
        return $this->morphTo();
    }
    //-------------------------------------------------
    public static function syncModuleMigrations($module_id,$batch_num)
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
            ->where('batch', $batch_num)
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
    public static function syncThemeMigrations($theme_id,$batch_num)
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
            ->where('batch', $batch_num)
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
    public static function resetMigrations($path=null, $force=false)
    {
        $command = 'migrate:reset';
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
    public static function refreshMigrations($path=null, $force=false)
    {
        $command = 'migrate:refresh';
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
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
            return $response;
        }


    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------

}
