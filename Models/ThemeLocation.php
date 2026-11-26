<?php namespace WebReinvent\VaahCms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class ThemeLocation extends VaahModel {

    //-------------------------------------------------
    //-------------------------------------------------
    protected $table = 'vh_theme_locations';
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
    public function scopeType( $query, $type) {
        return $query->where( 'type', $type );
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
    /**
     * F06 / ADR-008 — the relation's target (the Cms Menu model) is resolved
     * by the bound CmsContract; unbound (core-only install) returns null.
     */
    public function menus()
    {
        return vh_cms_contract()?->locationMenus($this);
    }

    //-------------------------------------------------

    //-------------------------------------------------
    public static function getMenuLocationsForAssets()
    {

        $list = ThemeLocation::theme(vh_get_theme_id())
            ->type('menu')
            ->get();

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
    //---------------------------------------------------------------------------
    public static function getLocationData($slug, $html=false, $type='bulma', $location_type = 'menu')
    {

        $data = [];

        $location = ThemeLocation::theme(vh_get_theme_id())
            ->slug($slug)
            ->where('type',$location_type)
            ->first();

        if(!$location)
        {
            return false;
        }

        /*
         * F06 / ADR-008 — the menu and block data lives in the Cms module;
         * with no bound contract both cases degrade to the same `false`
         * returned above when the location itself is not found.
         */
        $cms_contract = vh_cms_contract();

        switch ($location->type)
        {
            case 'menu':

                if($cms_contract === null)
                {
                    return false;
                }

                $data = ThemeLocation::getMenuLocation($location, $html, $type);

                break;

            //---------------------------------------
            case 'sidebar':

                break;

            //---------------------------------------
            case 'block':

                if($cms_contract === null)
                {
                    return false;
                }

                $data = $cms_contract->locationBlocks($location);

                break;
            //---------------------------------------
            //---------------------------------------
            //---------------------------------------

        }


        return $data;
    }

    //---------------------------------------------------------------------------
    public static function getMenuLocation($location, $html, $type)
    {

        /*
         * F06 / ADR-008 — the Menu model is resolved by the bound
         * CmsContract; the relation is already constrained to the
         * location, so the two Menu::where() sites collapse into it.
         */
        $menus = vh_cms_contract()?->locationMenus($location);

        if($menus === null)
        {
            return false;
        }

        $menus_count = $menus->count();

        if($menus_count == 0)
        {
            return false;
        }

        $result = [];
        $menu_html = "";
        $i = 0;

        $find_menus = $menus
            ->with(['items' => function($q){
                $q->with(['content']);
                $q->orderBy('sort','asc');
            }])
            ->get();

        foreach ($find_menus as $menu)
        {
            $result[$i] = $menu;

            if($html == true)
            {
                $menu_html .= ThemeLocation::getMenuHtml($result[$i], $type);
            }

            $i++;
        }

        if($html == true)
        {
            return $menu_html;
        } else
        {
            if(count($result) == 1)
            {
                return $result[0];
            } else
            {
                return $result;
            }
        }






    }
    //---------------------------------------------------------------------------
    public static function getMenuHtml($menu, $type)
    {


        $html = "";
        switch($type)
        {
            case 'bootstrap':
                $html = get_bootstrap_menu($menu, false);
                break;

            case 'ulli':
                $html = '<ul>';
                $html .= get_ulli_menu($menu, false);
                $html .= '</ul>';
                break;

            case 'bulma':
                $html = get_bulma_menu($menu, false);
                break;
        }


        return $html;
    }

    //---------------------------------------------------------------------------
    //---------------------------------------------------------------------------
    //---------------------------------------------------------------------------
    //---------------------------------------------------------------------------
    //---------------------------------------------------------------------------
    //---------------------------------------------------------------------------

}
