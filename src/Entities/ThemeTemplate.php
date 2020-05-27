<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use VaahCms\Modules\Cms\Entities\Content;
use VaahCms\Modules\Cms\Entities\ContentType;
use VaahCms\Modules\Cms\Entities\FormField;
use VaahCms\Modules\Cms\Entities\FormGroup;
use VaahCms\Modules\Cms\Entities\Group;
use VaahCms\Modules\Cms\Entities\Page;


class ThemeTemplate extends Model {

    //-------------------------------------------------
    protected $table = 'vh_theme_templates';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
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
    public function groups()
    {
        return $this->morphMany(FormGroup::class, 'groupable');
    }
    //-------------------------------------------------

    public static function syncWithFormGroups(ThemeTemplate $template, $groups_array)
    {

        $stored_groups = $template->groups()->get()->pluck('id')->toArray();

        $input_groups = collect($groups_array)->pluck('id')->toArray();
        $groups_to_delete = array_diff($stored_groups, $input_groups);

        if(count($groups_to_delete) > 0)
        {
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
                $stored_group =$template->groups()->save($group_fillable);
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
