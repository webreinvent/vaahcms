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

import {useJobStore} from '../../../stores/advanced/store-jobs'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";
const root = useRootStore();
const store = useJobStore();
const route = useRoute();

import { useConfirm } from "openvue/useconfirm";
import {useRootStore} from "../../../stores/root";
const confirm = useConfirm();

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
        <div :class="'col-'+store.list_view_width">
            <Panel class="vc-dense">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <h1 class="jobs-list-heading"
                             v-if="store.assets && store.assets.language_strings">
                            <b>{{store.assets.language_strings.jobs_title}}</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total"
                            />
                        </h1>
                    </div>
                </template>

                <template #icons>
                    <InputGroup>
                        <Button size="small" class="" data-testid="jobs-content-refresh" icon="pi pi-refresh" aria-label="Sync jobs" :loading="store.is_btn_loading" @click="store.sync" />
                    </InputGroup>
                </template>

                <!-- UT-115 — the "this list holds only queued jobs" note was the
                     engine's default `<Message>`, which fills the whole box with
                     the Nide preset's literal info fill — a blue-grey slab that
                     reads as a panel, not as a note, and in dark mode is the
                     loudest thing on the screen. It is now the app's own info
                     band (`.vc-notice-info`) with the info-circle glyph as the
                     non-colour signal — the same shape every other notice in the
                     admin uses (UT-112). Presentation only; the string, its
                     source and the list it describes are untouched. -->
                <div class="jobs-notice vc-notice vc-notice-info"
                     data-testid="jobs-notice"
                >
                    <i class="pi pi-info-circle vc-notice-icon"
                       aria-hidden="true"></i>
                    <p class="vc-notice-text">
                        {{store.assets.language_strings.jobs_message }}
                    </p>
                </div>

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

/* UT-108 — the panel title and its count badge are one centred row. The
   badge is 19.3px tall against a 17px line of 14px text, so on the text
   baseline it hung 2.6px below the title instead of sitting level with it. */
.jobs-list-heading {
    /* UT-129 — the panel title is the screen's single top-level
       heading, so it is an <h1>; the UA's h1 size and weight are pinned
       back to what the <div> inherited, so the rendering is unchanged. */
    font-size: inherit;
    font-weight: inherit;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* UT-115 — the note sits below the toolbar, so it needs its own gap; the
   band's shape and tone come from the shared `.vc-notice` / `.vc-notice-info`
   classes in the token layer. */
.jobs-notice {
    margin-bottom: 12px;
}
</style>
