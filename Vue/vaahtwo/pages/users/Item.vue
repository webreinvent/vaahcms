<script setup>
import { onMounted, ref, watch } from "vue";
import { useRoute } from 'vue-router';
import { useUserStore } from '../../stores/store-users'
import { vaah } from '../../vaahvue/pinia/vaah';
import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';

const store = useUserStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {

    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if (route.params && !route.params.id) {
        store.toList();
        return false;
    }

    /**
     * Fetch the record from the database
     */
    if (!store.item) {
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
    <div class="col-5" >
        <Panel v-if="store && store.item">
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
                            :label=" '#' + store.item.id "
                            @click="useVaah.copy(store.item.id)"
                    />

                    <Button label="Edit"
                            @click="store.toEdit(store.item)"
                            icon="pi pi-pencil"
                    />

                    <!--item_menu-->
                    <Button
                        type="button"
                        @click="toggleItemMenu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"
                    />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true"
                    />
                    <!--/item_menu-->

                    <Button class="p-button-primary"
                            icon="pi pi-times"
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

                    <div class="flex align-items-center justify-content-between">
                        <div class="">
                            Deleted {{store.item.deleted_at}}
                        </div>

                        <div class="">
                            <Button label="Restore"
                                    class="p-button-sm"
                                    @click="store.itemAction('restore')"
                            />
                        </div>
                    </div>
                </Message>

                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
                    <table class="p-datatable-table">
                        <tbody class="p-datatable-tbody">
                            <template v-for="(value, column) in store.item ">

                                <template v-if="column === 'created_by' || column === 'updated_by'" />

                                <template v-else-if="column === 'id' || column === 'uuid'">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               :can_copy="true"
                                    />
                                </template>

                                <template v-else-if="(column === 'created_by_user' || column === 'updated_by_user'  || column === 'deleted_by_user') && (typeof value === 'object' && value !== null)"
                                >
                                    <VhViewRow :label="column"
                                               :value="value"
                                               type="user"
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
