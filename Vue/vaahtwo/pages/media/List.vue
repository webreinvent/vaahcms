<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useMediaStore} from '../../stores/store-media';
import {useRootStore} from "../../stores/root";

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";
const root = useRootStore();
const store = useMediaStore();
const route = useRoute();


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
});

</script>
<template>
    <div class="grid" v-if="store.assets">

        <!-- M6-T1 — the three tiles were `p-fieldset card p-3` divs carrying
             PrimeFlex `text-sm` (12.25px) / `text-xl` (17.5px) type and a
             `bg-blue-50` / `text-blue-400` icon disc. Both are off-contract:
             the type is off the DESIGN-SYSTEM scale (12 · 13 · 14 · 16 · 20 ·
             24) and the palette utilities resolve to *primitive* tokens
             (`--p-blue-50`, `--p-blue-400`) which are scheme-invariant — the
             disc stayed a bright light-blue hole in dark mode. The tile is
             now an OpenVue `Card` (the app's own surface) and the type and
             the tint follow the dashboard's stat vocabulary.

             The tiles stack below the `md` breakpoint (`col-12 md:col-4`,
             the dashboard's own stat grid): three cards side by side in a
             375px viewport left each of them ~100px wide, and the labels
             and the counts wrapped into three and two lines. -->
        <div class="col-12">
            <div class="grid m-0">

                <div class="col-12 md:col-4">
                    <Card>
                        <template #content>
                            <div class="media-stat">
                                <span class="media-stat-icon">
                                    <i class="pi pi-file"></i>
                                </span>
                                <div class="media-stat-text">
                                    <p class="media-stat-label">{{store.assets.language_strings.total_medias_heading}}</p>
                                    <div v-if="store.list" class="media-stat-count">
                                        {{ store.list.total}}
                                    </div>
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>

                <div class="col-12 md:col-4">
                    <Card>
                        <template #content>
                            <div class="media-stat">
                                <span class="media-stat-icon">
                                    <i class="pi pi-upload"></i>
                                </span>
                                <div class="media-stat-text">
                                    <p class="media-stat-label">{{store.assets.language_strings.total_file_size_heading}}</p>
                                    <div v-if="store.list" class="media-stat-count">
                                        {{ store.total_file_size }} MB
                                    </div>
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>

                <div class="col-12 md:col-4">
                    <Card>
                        <template #content>
                            <div class="media-stat">
                                <span class="media-stat-icon">
                                    <i class="pi pi-trash"></i>
                                </span>
                                <div class="media-stat-text">
                                    <p class="media-stat-label">{{store.assets.language_strings.trashed_file_size_heading}}</p>
                                    <div v-if="store.list" class="media-stat-count">
                                        {{ store.trashed_file_size}} MB
                                    </div>
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
        </div>

        <div :class="'col-'+store.list_view_width">
            <Panel class="vc-dense">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <!-- M6-T1 (D1) — the count badge beside the panel
                             title. The badge is an inline-flex box whose
                             height comes from the engine's theme (19.25px)
                             and whose text sat on the *inherited* 20px line
                             box, so the digit overflowed the badge and was
                             clipped (measured: `scrollHeight` 20 >
                             `clientHeight` 19). The badge now carries its
                             own line box (the shared badge rule in
                             `scss/controls-layer.scss`) and the title and
                             the badge are one centred row, so the count
                             sits on the title's baseline instead of
                             hanging below it. -->
                        <h1 class="media-list-heading"
                             v-if="store.assets && store.assets.language_strings">
                            <b>{{store.assets.language_strings.media_title}}</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total"
                            />
                        </h1>
                    </div>
                </template>

                <template #icons>
                    <InputGroup v-if="root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions"
                    >
                        <Button size="small" data-testid="media-list-create" @click="store.toForm()" icon="pi pi-plus" :label="root.assets.language_strings.crud_actions.create_button" class="vaah-btn-primary" v-if="store.hasPermission('can-create-media')" />

                        <Button size="small" data-testid="media-list-reload" @click="store.reload()" :loading="store.is_btn_loading" icon="pi pi-refresh" aria-label="Reload media list" class="" />
                    </InputGroup>
                </template>

                <Actions v-if="root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions"
                />
                <Table/>
            </Panel>
        </div>

        <RouterView/>
    </div>
</template>

<style scoped>
/* M6-T1 (D1) — the panel title and its count badge are one centred row:
   the badge is a 19.25px box and the title a 14px line, so on the text
   baseline the badge hung below the title and its digit was clipped. */
.media-list-heading {
    /* UT-129 — the panel title is the screen's single top-level
       heading, so it is an <h1>; the UA's h1 size and weight are pinned
       back to what the <div> inherited, so the rendering is unchanged. */
    font-size: inherit;
    font-weight: inherit;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* ── The stat row: three tiles, one system (DESIGN-SYSTEM.md §6 type scale,
   §9 dark-mode parity). The vocabulary is the dashboard's stat vocabulary
   (`pages/dashboard/Dashboard.vue` → `.dash-stat-*`), so the two screens
   that both carry a stat row read as one surface.

   The disc is the only tinted element: 32px, a light-blue disc in the light
   scheme. `--p-blue-50` is a *primitive*, so it does not flip with the
   scheme — under `.app-dark` it would read as a bright hole in the card, so
   the dark scheme takes a dark surface and a light blue glyph instead. Same
   pairing, both schemes. */
.media-stat {
    display: flex;
    align-items: center;
}

.media-stat-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    margin-right: 16px;
    border-radius: 9999px;
    background: var(--p-blue-50);
    color: var(--vaah-link);
}

.app-dark .media-stat-icon {
    background: var(--p-surface-800);
    color: var(--p-blue-300);
}

.media-stat-text {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.media-stat-label {
    margin: 0;
    font-size: 13px;
    line-height: 1.4;
    color: var(--p-text-muted-color);
}

.media-stat-count {
    margin: 2px 0 0;
    font-size: 20px;
    line-height: 1.3;
    font-weight: 600;
}
</style>
