<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useNotificationStore} from '../../../stores/settings/store-notification'

import Actions from "../notifications/components/Actions.vue";
import Index from "../notifications/components/Index.vue";
const root = useRootStore();
const store = useNotificationStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";
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
            <Panel class="is-small" v-if="store.assets">
                <template class="p-1" #header>
                    <div class="flex flex-row">
                        <div v-if="store.assets && store.assets.language_strings">
                            <b class="mr-1">{{store.assets.language_strings.notification_heading}}</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total"
                            />
                        </div>
                    </div>
                </template>
                <template #icons>
                    <div class="buttons">
                        <Button icon="pi pi-plus"
                                :label="store.assets.language_strings.add_button"
                                class="p-button-sm"
                                @click="store.addNewNotification"
                                data-testid="setting-notification_add_new"
                                :disabled="store.active_notification"
                        />
                    </div>
                </template>
                <div v-if="store.show_new_item_form && !store.active_notification">
                    <div class="p-inputgroup">
                        <inputText data-testid="setting-notification_add_new_value"
                                   v-model="store.new_item.name"
                                   :placeholder="store.assets.language_strings.placeholder_enter_new_notification_name"
                                   :autoResize="true"
                                   class="w-full"
                                   inputClass="p-inputtext-sm"
                        />
                        <Button icon="pi pi-save"
                                :label="store.assets.language_strings.notification_save_button"
                                @click="store.create"
                                data-testid="setting-notification_save_new"
                                class="has-max-height p-button-sm"
                        />
                    </div>
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
