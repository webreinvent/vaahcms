<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use VaahCms\Modules\Cms\Entities\FormField;


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
        return $this->morphMany('VaahCms\Modules\Cms\Entities\FormGroup',
            'groupable');
    }
    //-------------------------------------------------
    public function formFields()
    {
        return $this->morphMany('VaahCms\Modules\Cms\Entities\FormField',
            'fieldable');
    }
    //-------------------------------------------------

    //-------------------------------------------------
    public static function syncTemplateFields($inputs)
    {

        $theme = Theme::slug($inputs['theme_slug'])->first();

        $template = ThemeTemplate::slug($inputs['page_template'])
            ->where('vh_theme_id', $theme->id)
            ->first();

/*
        $max_field_order = $template->formFields()->get()->max('order');
        $max_field_order = $max_field_order+1;
        $inputs['order'] = $max_field_order;

        */

        $inputs['slug'] = str_slug($inputs['name']);

        unset($inputs['page_template']);
        unset($inputs['theme_slug']);

        $field = FormField::firstOrCreate($inputs);

        $template->formFields()->save($field);


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
