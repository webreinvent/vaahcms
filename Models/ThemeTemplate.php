<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class ThemeTemplate extends VaahModel {

    //-------------------------------------------------
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
    /**
     * F06 / ADR-008 — the relation's target (the Cms FormGroup model) is
     * resolved by the bound CmsContract; with no binding (core-only install)
     * this returns null so "no relation" stays distinguishable from "no rows".
     */
    public function groups()
    {
        return vh_cms_contract()?->templateGroups($this);
    }
    //-------------------------------------------------

    public static function syncWithFormGroups(ThemeTemplate $template, $groups_array)
    {

        if(count($groups_array) < 1)
        {
            return false;
        }

        /*
         * F06 / ADR-008 — the group/field models live in the Cms module;
         * without a bound contract there is nothing to sync against, so
         * degrade to the same `false` the empty-array branch already returns.
         */
        $contract = vh_cms_contract();
        if($contract === null)
        {
            return false;
        }

        return $contract->syncTemplateGroups($template, $groups_array);
    }

    //-------------------------------------------------

    //-------------------------------------------------


    //-------------------------------------------------

}
