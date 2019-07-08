<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use VaahCms\Modules\Cms\Entities\Content;
use VaahCms\Modules\Cms\Entities\FormField;
use VaahCms\Modules\Cms\Entities\FormGroup;
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
    ];

    //-------------------------------------------------
    protected $appends  = [

    ];

    //-------------------------------------------------

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
    public static function syncTemplateFieldsViaViewRendering($inputs)
    {

        $theme = session('theme');

        if(!isset($theme))
        {
            $theme = Theme::active()->first();
        }

        $template = session('template');

        $inputs['slug'] = str_slug($inputs['name']);
        $inputs['group_slug'] = $theme->slug."-".$template->slug."-".str_slug($inputs['name']);

        $group = FormGroup::firstOrCreate(['slug' => $inputs['group_slug']]);
        $group->fill($inputs);
        $group->slug = $inputs['group_slug'];
        $group->is_auto_generated = true;
        $group->save();

        $template->formGroups()->save($group);

        $field = FormField::where('vh_cms_form_group_id', $group->id)
            ->where('slug', $inputs['slug'])->first();

        if(!$field)
        {
            $field = new FormField();
        }

        $field->fill($inputs);
        $field->vh_cms_form_group_id = $group->id;
        $field->save();

        $content  = ThemeTemplate::getPageFieldContent($field);

        return $content;

    }
    //-------------------------------------------------
    public static function getPageFieldContent($field)
    {
        $page = session('page')->toArray();


        $content = Content::where('contentable_type', Page::class)
            ->where('contentable_id', $page['id'])
            ->where('vh_cms_form_group_id', $field->vh_cms_form_group_id)
            ->where('vh_cms_form_field_id', $field->id)
            ->first();

        if ($content)
        {
            return $content->content;
        }


        return null;

    }
    //-------------------------------------------------
    public static function syncPageTemplates()
    {
        $get_page_templates = vh_get_page_templates();

        if(count($get_page_templates) > 0)
        {
            foreach ($get_page_templates as $template)
            {
                $template = str_replace(".blade.php", "", $template);

                $slug = str_slug($template);

                $template_exist = ThemeTemplate::theme(vh_get_theme_id())
                    ->slug($slug)
                    ->first();

                if(!$template_exist)
                {

                    $new_template = new ThemeTemplate();
                    $new_template->name = slug_to_str($slug);
                    $new_template->type = 'page';
                    $new_template->slug = slug_to_str($slug);
                    $new_template->vh_theme_id = vh_get_theme_id();
                    $new_template->save();

                }

            }
        }

    }
    //-------------------------------------------------
    public static function getAssetsList()
    {

        ThemeTemplate::syncPageTemplates();

        $list = ThemeTemplate::theme(vh_get_theme_id())->get();

        $result = [];
        $i = 0;
        foreach ($list as $item)
        {

            $result[$i]['name'] = $item->name;
            $result[$i]['id'] = $item->id;

            $i++;
        }

        return $result;

    }
    //-------------------------------------------------
    public static function getDefaultPageTemplate()
    {

        $item = ThemeTemplate::theme(vh_get_theme_id())
            ->where('type', 'page')
            ->where('slug', 'default')
            ->first();

        $result['name'] = $item->name;
        $result['id'] = $item->id;

        return $result;

    }
    //-------------------------------------------------
    public static function syncTemplateCustomFields($template_id)
    {
        $template = ThemeTemplate::find($template_id);

        \Session::put('template', $template);

        //sync all the fields types
        view(vh_get_theme_slug()."::page-templates.".$template->slug)->render();

        $template = ThemeTemplate::find($template->id);

        return $template;
    }
    //-------------------------------------------------

}
