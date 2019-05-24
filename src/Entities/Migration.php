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

}
