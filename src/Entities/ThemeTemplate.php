<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use VaahCms\Modules\Cms\Entities\FormField;
use VaahCms\Modules\Cms\Entities\FormGroup;


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
    ];

    //-------------------------------------------------
    public function setSlugAttribute( $value ) {
        $this->attributes['slug'] = str_slug( $value );
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
    public function formGroups()
    {
        return $this->morphMany(FormGroup::class,
            'groupable');
    }

    //-------------------------------------------------

    //-------------------------------------------------
    public static function syncTemplateFields($inputs)
    {

        $theme = Theme::slug($inputs['theme_slug'])->first();

        $template = ThemeTemplate::slug($inputs['page_template'])
            ->where('vh_theme_id', $theme->id)
            ->first();


        $inputs['slug'] = str_slug($inputs['name']);
        $inputs['group_slug'] = $theme->slug."-".$template->slug."-".str_slug($inputs['name']);

        unset($inputs['page_template']);
        unset($inputs['theme_slug']);



        $group = FormGroup::firstOrCreate(['slug' => $inputs['group_slug']]);
        $group->fill($inputs);
        $group->slug = $inputs['group_slug'];
        $group->is_auto_generated = true;
        $group->save();

        $template->formGroups()->save($group);

        $field = FormField::where('vh_cms_form_group_id', $template->id)
            ->where('slug', $inputs['slug'])->first();

        if(!$field)
        {
            $field = new FormField();
        }

        $field->fill($inputs);
        $field->vh_cms_form_group_id = $template->id;
        $field->save();



    }
    //-------------------------------------------------
    public static function getAssetsList()
    {

        $list = ThemeTemplate::theme(vh_get_theme_id())->get();

        $result = [];
        $i = 0;
        foreach ($list as $item)
        {

            $result[$i]['label'] = $item->name;
            $result[$i]['code'] = $item->slug;

            $i++;
        }

        return $result;

    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------

}
