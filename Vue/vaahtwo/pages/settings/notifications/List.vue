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

import {useNotificationStore} from '../../../stores/settings/store-notification'

import Actions from "../notifications/components/Actions.vue";
import Index from "../notifications/components/Index.vue";
const root = useRootStore();
const store = useNotificationStore();
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
    <div class="grid">
        <div :class="'col-'+store.list_view_width">
            <Panel class="vc-dense" v-if="store.assets">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <h1 class="notifications-list-heading"
                             v-if="store.assets && store.assets.language_strings">
                            <b class=" vaah-type-title">{{store.assets.language_strings.notification_heading}}</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total"
                            />
                        </h1>
                    </div>
                </template>
                <template #icons>
                    <div class="buttons">
                        <Button size="small" icon="pi pi-plus" :label="store.assets.language_strings.add_button" class="" @click="store.addNewNotification" data-testid="setting-notification_add_new" :disabled="store.active_notification" />
                    </div>
                </template>
                <div v-if="store.show_new_item_form && !store.active_notification">
                    <InputGroup>
                        <inputText data-testid="setting-notification_add_new_value"
                                   v-model="store.new_item.name"
                                   :placeholder="store.assets.language_strings.placeholder_enter_new_notification_name"
                                   :autoResize="true"
                                   class="w-full"
                                   size="small"
                        />
                        <Button size="small" icon="pi pi-save" :label="store.assets.language_strings.notification_save_button" @click="store.create" data-testid="setting-notification_save_new" class="has-max-height" />
                    </InputGroup>
                </div>


                <Actions v-if="root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions"
                />
                <Index/>
            </Panel>
        </div>

        <RouterView/>
    </div>
</template>

<style scoped>

/* UT-108 — the panel title and its count badge are one centred row. The
   badge is 19.3px tall against a 17px line of 14px text, so on the text
   baseline it hung 2.6px below the title instead of sitting level with it. */
.notifications-list-heading {
    /* UT-129 — the panel title is the screen's single top-level
       heading, so it is an <h1>; the UA's h1 size and weight are pinned
       back to what the <div> inherited, so the rendering is unchanged. */
    font-size: inherit;
    font-weight: inherit;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
</style>
