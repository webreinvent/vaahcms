<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';
import { vaah } from '../../vaahvue/pinia/vaah';
import { usePermissionStore } from '../../stores/store-permissions';
import { useRootStore } from "../../stores/root";
import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';

const store = usePermissionStore();
const root = useRootStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {

    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if(route.params && !route.params.id)
    {
        store.toList();
        return false;
    }

    /**
     * Fetch the record from the database
     */
    if(!store.item)
    {
        await store.getItem(route.params.id);
    }

    /**
     * Watch if url record id is changed, if changed
     * then fetch the new records from database
     */
    /*watch(route, async (newVal,oldVal) =>
        {
            if(newVal.params && !newVal.params.id
                && newVal.name === 'articles.view')
            {
                store.toList();

            }
            await store.getItem(route.params.id);
        }, { deep: true }
    )*/

});

//--------toggle item menu
const item_menu_state = ref();
const toggleItemMenu = (event) => {
    item_menu_state.value.toggle(event);
};
//--------/toggle item menu

</script>
<template>

    <div class="col-5">
        <Panel v-if="store && store.item" class="is-small">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="font-semibold text-sm">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">
                    <Button class="p-button-sm"
                            :label=" '#' + store.item.id"
                            @click="useVaah.copy(store.item.id)"
                            data-testid="permission-item_id"
                    />

                    <Button class="p-button-sm"
                            :label="root.assets.language_strings.crud_actions.view_edit"
                            icon="pi pi-pencil"
                            data-testid="permission-item_edit"
                            @click="store.toEdit(store.item)"
                            v-if="store.hasPermission('can-update-permissions') && root.assets
                                  && root.assets.language_strings
                                  && root.assets.language_strings.crud_actions"
                    />

                    <!--item_menu-->
                    <Button class="p-button-sm"
                            icon="pi pi-angle-down"
                            type="button"
                            aria-haspopup="true"
                            data-testid="permission-item_menu"
                            @click="toggleItemMenu"
                            v-if="store.hasPermission('can-update-permissions') || store.hasPermission('can-manage-permissions')"
                    />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true" />
                    <!--/item_menu-->

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            data-testid="permission-item_list"
                            @click="store.toList()"
                    />
                </div>
            </template>


            <div v-if="store.item">

                <Message severity="error"
                         class="p-container-message"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item.deleted_at"
                >

                    <div class="flex align-items-center justify-content-between" v-if="root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions">

                        <div class="">
                            {{root.assets.language_strings.crud_actions.view_deleted}} {{store.item.deleted_at}}
                        </div>

                        <div class="ml-3">
                            <Button :label="root.assets.language_strings.crud_actions.view_restore"
                                    class="p-button-sm"
                                    @click="store.itemAction('restore')">
                            </Button>
                        </div>
                    </div>
                </Message>

                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
                    <table class="p-datatable-table">
                        <tbody class="p-datatable-tbody">
                            <template v-for="(value, column) in store.item ">
                                <template v-if="column === 'created_by' || column === 'updated_by'">
                                </template>
                                <template v-else-if="column === 'id' || column === 'uuid' || column === 'slug'">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               :can_copy="true"
                                    />
                                </template>
                                <template v-else-if="(column === 'created_by_user' || column === 'updated_by_user'  || column === 'deleted_by_user') && (typeof value === 'object' && value !== null)">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               type="user"
                                    />
                                </template>
                                <template v-else-if="column === 'count_users'|| column === 'count_roles' ">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               type="tag"
                                    />
                                </template>
                                <template v-else-if="column === 'is_active'">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               type="yes-no"
                                    />
                                </template>

                                <template v-else>
                                    <VhViewRow :label="column"
                                               :value="value"
                                    />
                                </template>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </Panel>
    </div>
</template>
