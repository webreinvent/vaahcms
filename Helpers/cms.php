<?php

use WebReinvent\VaahCms\Contracts\CmsContract;

/**
 * F06 / R2.9, ADR-008 — the single resolver for the optional Cms contract.
 *
 * `VaahCmsServiceProvider::register()` binds nothing; the Cms module's own
 * provider is the only binder. With no binding in place (a core-only
 * install) every call site gets `null` and degrades as documented —
 * core boots standalone.
 */
function vh_cms_contract(): ?CmsContract
{
    return app()->bound(CmsContract::class) ? app(CmsContract::class) : null;
}
//-------------------------------------------------------------
/**
 * F19 / R2.9 — the EXPLICIT degradation of the optional Cms module for the
 * taxonomies surface.
 *
 * F19 requires the missing optional module to be observable, never silent:
 * the API response carries an availability marker
 * (`content_form_binding.available`) and the same fact is written to
 * `storage/logs` at warning level. The admin surface renders the matching
 * dismissible warning message (see `pages/taxonomies/List.vue`).
 *
 * The log line is de-duplicated on the session — the same pattern as
 * `vh_record_hook_failure()` in `Helpers/actions.php` — so a reloaded page
 * never multiplies it: ONE warning-level line per admin session.
 *
 * This helper is additive: it reads the container, it never binds anything,
 * and it does not touch the taxonomy domain (schema, hierarchy, slug and
 * uniqueness rules, ordering, notifications) — D3.
 */
function vh_cms_content_form_binding(): array
{
    $available = vh_cms_contract() !== null;

    if(!$available) {
        $key = 'vaahcms.cms_degradation_reported';

        if(!session()->has($key)) {
            session()->put($key, now()->toIso8601String());

            \Log::warning(
                'vaahcms: the optional Cms module is not installed — '
                .'content-form-field binding for taxonomies is unavailable.'
            );
        }
    }

    return ['available' => $available];
}
