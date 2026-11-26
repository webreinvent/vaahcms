<?php

namespace WebReinvent\VaahCms\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use WebReinvent\VaahCms\Models\Taxonomy;
use WebReinvent\VaahCms\Models\ThemeLocation;
use WebReinvent\VaahCms\Models\ThemeTemplate;

/**
 * F06 / R2.9, ADR-008 — the optional bridge from core to the `Cms` module.
 *
 * Core no longer `use`s any Cms-module class (the package ships no psr-4
 * mapping for the first-party module namespace on purpose). The `Cms`
 * module's own service provider binds this contract to its implementation;
 * until then `vh_cms_contract()` returns `null` and every call site
 * degrades (see the feature doc's null-default scenarios).
 *
 * The relation-returning methods hand back Eloquent relations, not data:
 * their callers use the relation API (`->get()`, `->where()`, `->save()`),
 * so the relation stays on the Cms side and only the class reference moves
 * behind the container. Methods return `null` — not an empty collection —
 * when the module is absent, so "no relation" stays distinguishable from
 * "no rows".
 */
interface CmsContract
{
    /**
     * The `morphMany` relation of form groups attached to a template.
     */
    public function templateGroups(ThemeTemplate $template): ?MorphMany;

    /**
     * Persist the template's form groups (delete removed, update/create kept).
     */
    public function syncTemplateGroups(ThemeTemplate $template, array $groups): bool;

    /**
     * The `hasMany` relation of menus attached to a theme location.
     */
    public function locationMenus(ThemeLocation $location): ?HasMany;

    /**
     * The blocks collected at a theme location (the Cms
     * `Block::getBlocksByLocation()` equivalent).
     */
    public function locationBlocks(ThemeLocation $location): ?Collection;

    /**
     * The `morphToMany` relation of content form fields on a taxonomy.
     */
    public function taxonomyContentFormFields(Taxonomy $taxonomy): ?MorphToMany;

    /**
     * The home-page menu item, or `null` when none is set / no module bound
     * the contract.
     */
    public function homePageMenuItem(): ?object;
}
