<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import { onMounted, reactive, ref } from "vue";
import { useRoute } from 'vue-router';
import { useRootStore } from "../../stores/root";
import { useTaxonomyStore } from '../../stores/store-taxonomies'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";
import TaxonomyTypeModal from "./components/TaxonomyTypeModal.vue";

const root = useRootStore();
const store = useTaxonomyStore();
const route = useRoute();

import { useConfirm } from "openvue/useconfirm";
const confirm = useConfirm();

import { useDialog } from "openvue/usedialog";
const dialog = useDialog();

// UT-90 (M6-T4a Batch 17) — the "Manage taxonomy type" action used to be
// a pencil inside *every* row's Type cell, beside the row's own Edit
// pencil: two identical pencils in one row, and the first one did not
// act on the row at all — it opens the global taxonomy-type manager. It
// now lives once, in the panel header, next to Create and Sync.
const openTaxonomyTypeModal = () => {
    dialog.open(TaxonomyTypeModal, {
        props: {
            header: store.assets.language_strings.taxonomy_type_manage_type_dialogue,
            style: {
                width: '50vw',
            },
            breakpoints:{
                '960px': '75vw',
                '640px': '90vw'
            },
            modal: true
        }
    });
}


onMounted(async () => {
    /**
     * call onLoad action when List view loads
     */
    await store.onLoad(route);

    /**
     * watch routes to update view, column width
     * and get new item when routes get changed
     */
    await store.setPageTitle();
    await store.watchRoutes(route);

    /**
     * watch states like `query.filter` to
     * call specific actions if a state gets
     * changed
     */
    await store.watchStates();

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();

    /**
     * Fetch the permissions from the database
     */
    await root.getPermission();
});

</script>

<template>
    <div class="grid" v-if="store.assets">
        <div :class="'col-'+store.list_view_width">
            <Panel class="vc-dense">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <h1 class="taxonomies-list-heading"
                             v-if="store.assets && store.assets.language_strings">
                            <b>{{store.assets.language_strings.taxonomy_title}}</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total"
                            />
                        </h1>
                    </div>
                </template>

                <template #icons>
                    <InputGroup>
                        <Button size="small" v-if="store.hasPermission('can-create-taxonomies')" class="" :label="root.assets.language_strings.crud_actions.create_button" data-testid="taxonomies-list-create" icon="pi pi-plus" @click="store.toForm()" />

                        <!-- UT-90 (M6-T4a Batch 17) — the taxonomy-type
                             manager moved here from the per-row Type cell. -->
                        <Button size="small" v-if="store.hasPermission('can-manage-taxonomy-types') && store.assets.language_strings.toolkit_text_view_type" class=""
                                :label="store.assets.language_strings.toolkit_text_view_type"
                                data-testid="taxonomies-list-manage-taxonomy-type"
                                icon="pi pi-sitemap"
                                @click="openTaxonomyTypeModal" />

                        <Button size="small" class="" icon="pi pi-refresh" aria-label="Sync taxonomies" :loading="store.is_btn_loading" @click="store.sync()" />
                    </InputGroup>
                </template>

                <!--
                    F19 / R2.9 — the operator-facing half of the EXPLICIT
                    degradation: the optional Cms module is not installed, so
                    the content-form-field binding for taxonomies is
                    unavailable (hidden and disabled, not merely empty).

                    Exactly ONE dismissible warning message names the missing
                    module and the consequence. The v4 `Message` hides itself
                    when its close button is pressed (`closable`), and it
                    carries NO `life` — the notice must stay until the admin
                    has seen it, so it is never auto-dismissed.

                    The `warn` severity is the right one — a missing optional
                    module is a caution, not an error (v4 Message severities:
                    error | secondary | info | success | warn | contrast).
                -->
                <Message v-if="store.assets.content_form_binding
                               && store.assets.content_form_binding.available === false"
                         severity="warn"
                         closable
                         icon="pi pi-exclamation-triangle"
                         class="mb-2"
                         data-testid="taxonomies-content-form-binding-warning">

                    The optional Cms module is not installed — content-form-field binding for taxonomies is unavailable.

                </Message>

                <Actions v-if="root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions"
                />
                <Table/>
            </Panel>
        </div>

        <RouterView/>

        <!-- UT-90 (M6-T4a Batch 17) — the dialog host travels with the
             opener, so the type manager is rendered by the same component
             that raises it. -->
        <DynamicDialog/>
    </div>
</template>

<style scoped>
/* UT-108 — the panel title and its count badge are one centred row. The
   badge is 19.3px tall against a 17px line of 14px text, so on the text
   baseline it hung 2.6px below the title instead of sitting level with it. */
.taxonomies-list-heading {
    /* UT-129 — the panel title is the screen's single top-level
       heading, so it is an <h1>; the UA's h1 size and weight are pinned
       back to what the <div> inherited, so the rendering is unchanged. */
    font-size: inherit;
    font-weight: inherit;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* M5-T4 (F19) — the degradation notice is body copy, so it sits on the 13px
   step of the type scale (12 · 13 · 14 · 16 · 20 · 24 at the 14px root).

   Left to itself the v4 Message renders its text at the engine's rem default,
   which measures 12.25px at this root — off-scale by 0.25px. The app already
   fixes this per screen rather than in the global token layer: see the
   identical rule in `pages/dashboard/Dashboard.vue`. */
:deep(.p-message .p-message-text) {
    font-size: 13px;
    line-height: 1.5;
}

/* M5-T4 (F19) — the panel header's action cluster must not clip at 375px.

   The global rule (UT-35) already wraps the panel header and gives the
   action cluster the full width, but the cluster here is a single
   `.p-inputgroup`, and the engine's input group is a NOWRAP flex row: the
   three header actions (Create · Manage Taxonomy Type · Sync) measured
   320px against the 287px the panel actually offers at 375px, so the Sync
   button painted past the panel's right edge.

   Letting the group wrap is the same move UT-34 already makes for the
   list toolbar's search cluster: the buttons keep their size and break
   onto a second row instead of being clipped. */
@media screen and (max-width: 640px) {
    :deep(.p-panel-header-actions .p-inputgroup) {
        flex-wrap: wrap;
    }

    :deep(.p-panel-header-actions .p-inputgroup > .p-button) {
        flex: 0 0 auto;
    }
}
</style>
