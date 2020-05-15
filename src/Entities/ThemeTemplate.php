<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
    public function fields()
    {
        return $this->hasMany(ThemeTemplateField::class,
            'vh_template_id', 'id')
            ->orderBy('sort', 'asc');
    }
    //-------------------------------------------------

    //-------------------------------------------------

    //-------------------------------------------------


    //-------------------------------------------------

}
