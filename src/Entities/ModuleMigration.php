<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;


class ModuleMigration extends Model {


    //-------------------------------------------------
    protected $table = 'vh_modules_migrations';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'migration_id',
        'module_id',
        'module_slug',
        'batch',
    ];

    //-------------------------------------------------
    public function module() {
        return $this->belongsTo( 'WebReinvent\VaahCms\Entities\Module',
            'module_id', 'id'
        );
    }
    //-------------------------------------------------
    public static function syncMigrations($module_id=null, $module_slug=null)
    {
        $migrations = \DB::table('migrations')->count();

        if($migrations < 1)
        {
            return false;
        }

        $migrations = \DB::table('migrations')->get();

        foreach ($migrations as $migration)
        {
            $module_migration = ModuleMigration::where('migration_id', $migration->id)->first();

            if(!$module_migration)
            {
                $module_migration = new ModuleMigration();
                $module_migration->migration_id = $migration->id;
                $module_migration->module_id = $module_id;
                $module_migration->module_slug = $module_slug;
                $module_migration->batch = $migration->batch;
                $module_migration->save();
            }

        }


        return true;
    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------

}
