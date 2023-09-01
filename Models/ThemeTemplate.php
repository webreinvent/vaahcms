<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use VaahCms\Modules\Cms\Models\Content;
use VaahCms\Modules\Cms\Models\ContentType;
use VaahCms\Modules\Cms\Models\FormField;
use VaahCms\Modules\Cms\Models\FormGroup;


class ThemeTemplate extends Model {

    //-------------------------------------------------
    protected $connection= 'mysql';
    //-------------------------------------------------
    protected $table = 'vh_theme_templates';
    //-------------------------------------------------
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'vh_theme_id',
        'type',
        'name',
        'slug',
        'file_path',
        'excerpt',
    ];

    //-------------------------------------------------
    protected $appends  = [

    ];

    //-------------------------------------------------



    //-------------------------------------------------
    protected function serializeDate(DateTimeInterface $date)
    {
        $date_time_format = config('settings.global.datetime_format');

        return $date->format($date_time_format);

    }

    //-------------------------------------------------

    //-------------------------------------------------
    public function setSlugAttribute( $value ) {
        $this->attributes['slug'] = Str::slug( $value );
    }
    //-------------------------------------------------
    public function scopeSlug( $query, $slug ) {
        return $query->where( 'slug', $slug );
    }
    //-------------------------------------------------
    public function scopeTheme( $query, $theme_id ) {
        return $query->where( 'vh_theme_id', $theme_id );
    }
    //-------------------------------------------------
    public function scopeCreatedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'created_at', array( $from, $to ) );
    }
    //-------------------------------------------------
    public function scopeUpdatedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'updated_at', array( $from, $to ) );
    }

    //-------------------------------------------------
    public function scopeDeletedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'deleted_at', array( $from, $to ) );
    }
    //-------------------------------------------------
    public function theme()
    {
        return $this->belongsTo(Theme::class, 'vh_theme_id', 'id');
    }
    //-------------------------------------------------
    public function groups()
    {
        return $this->morphMany(FormGroup::class, 'groupable');
    }
    //-------------------------------------------------

    public static function syncWithFormGroups(ThemeTemplate $template, $groups_array)
    {

        if(count($groups_array) < 1)
        {
            return false;
        }

        $stored_groups = $template->groups()->get()->pluck('slug','id')->toArray();

        $input_groups = collect($groups_array)->pluck('slug')->toArray();
        $groups_to_delete = array_diff($stored_groups, $input_groups);

        if(count($groups_to_delete) > 0)
        {
            $groups_to_delete = array_flip($groups_to_delete);
            FormGroup::deleteItems($groups_to_delete);
        }

        foreach($groups_array as $g_index => $group)
        {

            $group['sort'] = $g_index;
            $group['slug'] = Str::slug($group['name']);

            $stored_group = $template->groups()
                ->where('vh_cms_form_groups.slug', $group['slug'])
                ->first();

            $group_fillable = $group;

            unset($group_fillable['fields']);

            if($stored_group)
            {
                $stored_group->fill($group_fillable);
                $stored_group =$template->groups()->save($stored_group);
            } else{
                $stored_group = $template->groups()->create($group_fillable);
            }


            FormGroup::syncWithFormFields($stored_group, $group['fields']);

        }


    }

    //-------------------------------------------------

    //-------------------------------------------------


    //-------------------------------------------------

}
