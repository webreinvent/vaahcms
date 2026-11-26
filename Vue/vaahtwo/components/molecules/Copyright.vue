<script setup>
import {useRootStore} from "../../stores/root";

const root = useRootStore();
</script>

<template>
    <!-- UT-19 (M6-T4a Batch 5) — `text-xs` is 10.5px at the 14px root: the
         footer copy was below the readable floor.
         M6-T5 — the copy is now 13px (the scale's secondary size) instead of
         PrimeFlex's off-scale `text-sm` (12.25px), and the two links dropped
         the `text-blue-400` palette utility: the global anchor rule already
         binds them to `--vaah-link`, the scheme-aware, AA-compliant link
         colour (UT-21 / UT-29). -->
    <div v-if="root.assets" class="vc-text-13 text-center">

        <p v-if="root.assets.server">
            &copy; {{root.assets.server.current_year}}.
            <a :href="root.assets.vaahcms.website"
               name="copyright-vaahcms_name"
               data-testid="signin-vaahcms_name"
               target="_blank" >
                {{root.assets.vaahcms.name}}
            </a>
            v{{root.assets.versions.vaahcms_version}}
            | <a :href="root.assets.vaahcms.docs"
                 name="copyright-vaahcms_documentation"
                 data-testid="signin-vaahcms_documentation"
                 target="_blank">Documentation</a>
        </p>

        <p v-if="root.assets.versions">
            Laravel v{{root.assets.versions.laravel_version}}
            | PHP v{{root.assets.versions.php_version}}
        </p>
    </div>
</template>

<style scoped>
/* UT-107 — the footer's product link measured 56.3 × 15px: an inline <a>'s
   hit area is exactly its text box, below the contract's 24px minimum
   interactive size. Symmetric padding on the inline element (no display
   change, so the baseline does not shift and the paragraph's rhythm is
   preserved) grows the hit area to ≥24px without enlarging the visible
   text. */
a {
    padding: 5px 2px;
}
</style>

