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

    await store.getItemMenu();

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
                            :label=" '#' + store.item.id "
                            @click="useVaah.copy(store.item.id)"
                            data-testid="user-item_id"
                    />

                    <Button label="Edit"
                            @click="store.toEdit(store.item)"
                            icon="pi pi-pencil"
                            class="p-button-sm"
                            data-testid="user-item_edit"
                            v-if="store.hasPermission('can-update-users') || store.hasPermission('can-manage-users')"
                    />

                    <!--item_menu-->
                    <Button class="p-button-sm"
                            @click="toggleItemMenu"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"
                            data-testid="user-item_menu"
                            v-if="store.hasPermission('can-update-users') || store.hasPermission('can-manage-users')"
                    />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true"
                    />
                    <!--/item_menu-->

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            data-testid="user-list_view"
                            @click="store.toList()"
                    />
                </div>
            </template>

            <div v-if="store.item" class="mt-2">
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

                        <div class="ml-3">
                            <Button label="Restore"
                                    class="p-button-sm"
                                    data-testid="user-item_restore"
                                    @click="store.itemAction('restore')"
                            />
                        </div>
                    </div>
                </Message>

                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
                    <table class="p-datatable-table">
                        <tbody class="p-datatable-tbody">
                        <Avatar v-if="store.item.avatar" size="xlarge"
                                shape="circle"
                                :image="store.item.avatar"
                                alt="Avatar"
                        />
                            <template v-for="(value, column) in store.item ">

                                <template v-if="column === 'avatar_url' || column === 'avatar' || column === 'country_code'" />
                                <template v-else-if="column === 'created_by' || column === 'updated_by'" />

                                <template v-else-if="column === 'id' ||
                                                     column === 'uuid' ||
                                                     column === 'email' ||
                                                     column === 'username' ||
                                                     column === 'phone' ||
                                                     column === 'alternate_email' ||
                                                     column === 'registration_id'">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               :data-testid="'user-item_copy_'+column"
                                               :can_copy="true"
                                    />
                                </template>

                                <template v-else-if="(column === 'created_by_user' || column === 'updated_by_user'  || column === 'deleted_by_user') && (typeof value === 'object' && value !== null && !store.isHidden(column))"
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
                                <template v-else-if="column === 'bio' && !store.isHidden('bio')">
                                    <tr>
                                        <td style="font-weight:bold">{{vaah().toLabel(column)}}</td>
                                        <td>
                                            <Button class="p-button-secondary p-button-outlined p-button-rounded p-button-sm"
                                                    label="View"
                                                    icon="pi pi-eye"
                                                    data-testid="user-item_bio_modal"
                                                    @click="store.displayBioModal(value)"
                                                    v-if="value"
                                            />
                                        </td>
                                    </tr>
                                </template>

                                <template v-else-if="column === 'meta'">
                                    <tr>
                                        <td><b>Meta</b></td>
                                        <td v-if="value">
                                            <Button icon="pi pi-eye"
                                                    label="view"
                                                    class="p-button-outlined p-button-secondary p-button-rounded p-button-sm"
                                                    @click="store.openModal(value)"
                                                    data-testid="register-open_meta_modal"
                                            />
                                        </td>
                                    </tr>

                                    <Dialog header="Meta"
                                            v-model:visible="store.display_meta_modal"
                                            :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                                            :style="{width: '50vw'}" :modal="true"
                                    >
                                        <p class="m-0" v-html="'<pre>'+store.meta_content+'<pre>'"></p>
                                    </Dialog>

                                </template>
                                <template v-else>
                                    <VhViewRow :label="column"
                                               :value="value"
                                               v-if="!store.isHidden(column)"
                                    />
                                </template>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </Panel>

        <Dialog header="Bio"
                v-model:visible="store.display_bio_modal"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}"
                :modal="true"
        >
            <p class="m-3" v-html="store.bio_modal_data" />
        </Dialog>
    </div>
</template>
