<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';
import { useRegistrationStore } from '../../stores/store-registrations'
import { vaah } from '../../vaahvue/pinia/vaah'
import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';

const store = useRegistrationStore();
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

const item_status = ref();
const user_status = ref();

const toggleStatusMenu = (event) => {
    item_status.value[0].toggle(event);
};

const toggleUserStatusMenu = (event) => {
    user_status.value[0].toggle(event);
};
//---------------------------------------------------------------------
</script>

<template>
    <div class="col-5">
        <Panel v-if="store && store.item" class="is-small">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="p-panel-title">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">
                    <Button class="p-button-sm"
                            :label=" '#' + store.item.id "
                            @click="useVaah.copy(store.item.id)"
                            data-testid="registration-item_id"
                    />

                    <Button label="Edit"
                            class="p-button-sm"
                            @click="store.toEdit(store.item)"
                            icon="pi pi-pencil"
                            data-testid="register-view_to_edit"
                            v-if="store.hasPermission('can-update-registrations')"
                    />

                    <!--item_menu-->
                    <Button class="p-button-sm"
                            @click="toggleItemMenu"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"
                            data-testid="register-view_toggle_item_menu_list"
                            v-if="store.hasPermission('can-update-registrations') || store.hasPermission('can-manage-registrations')"
                    />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true" />

                    <!--/item_menu-->

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            @click="store.toList()"
                            data-testid="register-view_to_list"
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

                        <div class="">
                            <Button label="Restore"
                                    class="p-button-sm"
                                    @click="store.itemAction('restore')"
                                    data-testid="register-view_item_action_to_restore"
                            />
                        </div>
                    </div>
                </Message>

                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
                <table class="p-datatable-table">
                    <tbody class="p-datatable-tbody">
                        <template v-for="(value, column) in store.item ">
                            <template v-if="column === 'created_by' || column === 'updated_by'"/>

                            <template v-else-if="column === 'id' ||
                                                 column === 'uuid'||
                                                 column === 'first_name' ||
                                                 column === 'email' ||
                                                 column === 'username' ||
                                                 column === 'phone' ||
                                                 column === 'activation_code' ||
                                                 column === 'alternate_email'"
                            >
                                <VhViewRow :label="column"
                                           :value="value"
                                           :can_copy="true"
                                           data-testid="register-view_copy"
                                           v-if="!store.isHidden(column)"
                                />
                            </template>

                            <template v-else-if="column === 'middle_name' || column === 'last_name'||
                                                 column === 'website' || column === 'timezone' ||
                                                 column === 'country_calling_code' ||column === 'title' ||
                                                 column === 'designation'"
                            >
                                <VhViewRow :label="column"
                                           :value="value"
                                           :can_copy="false"
                                           data-testid="register-view_copy"
                                           v-if="!store.isHidden(column)"
                                />
                            </template>

                            <template v-else-if="column === 'birth' || column === 'foreign_user_id' ||
                                                 column === 'display_name'"
                            >
                                <VhViewRow :label="column"
                                           :value="value"
                                           :can_copy="false"
                                           data-testid="register-view_copy"
                                           v-if="!store.isHidden(column)"
                                />
                            </template>

                            <template v-else-if="(column === 'created_by_user' || column === 'updated_by_user'  || column === 'deleted_by_user') && (typeof value === 'object' && value !== null)"
                            >
                                <VhViewRow :label="column"
                                           :value="value"
                                           type="user"
                                           data-testid="register-view_user_copy"
                                />
                            </template>

                            <template v-else-if="column === 'bio'">
                                <tr v-if="!store.isHidden(column)">
                                    <td style="font-weight:bold">{{ vaah().toLabel(column) }}</td>
                                    <td>
                                        <Button class="p-button-secondary p-button-outlined p-button-rounded p-button-sm"
                                                label="View"
                                                icon="pi pi-eye"
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

                            <template v-else-if="column === 'status'" >
                                <tr>
                                    <td><b>Status</b></td>
                                    <td v-if="value" colspan="2">
                                        <div class="p-inputgroup">
                                            <Button :label="value"
                                                    v-if="value"
                                                    class="p-button-outlined p-button-secondary p-button-xs"
                                                    disabled="disabled"
                                            />

                                            <Button v-if="store.assets && store.assets.registration_statuses"
                                                    class="p-button-outlined wd-2rem
                                                     p-button-secondary p-button-xs"
                                                    @click="toggleStatusMenu"
                                                    icon="pi pi-angle-down"
                                                    aria-haspopup="true"
                                                    data-testid="register-view_toggle_statuses_menu"
                                            />

                                            <Menu ref="item_status"
                                                  :model="store.registrationStatus()"
                                                  :popup="true"
                                            />



                                            <Menu ref="user_status"
                                                  :model="store.userCreatedOption()"
                                                  :popup="true"
                                            />

                                            <Button v-if="value == 'email-verification-pending'"
                                                    label="Resend Verification Email"
                                                    class="p-button-info p-button-xs"
                                                    @click="store.sendVerificationEmail()"
                                                    data-testid="register-view_send_verification_email"
                                            />

                                            <Button v-if="value == 'email-verified'"
                                                    label="Create User"
                                                    class="p-button-success p-button-xs"
                                                     @click="store.confirmCreateUser()"
                                                    data-testid="register-view_confirm_create_user"
                                            />


                                            <Button v-if="value == 'email-verified'"
                                                    type="button"
                                                    @click="toggleUserStatusMenu"
                                                    icon="pi pi-angle-down"
                                                    aria-haspopup="true"
                                                    class="p-button-success p-button-xs"
                                                    data-testid="register-view_email_verified"
                                            />


                                        </div>
                                    </td>
                                </tr>
                            </template>

                            <template v-else-if="column === 'gender'">
                                <tr v-if="!store.isHidden(column)">
                                    <td><b>Gender</b></td>
                                    <td v-if="value">
                                        <Tag severity="primary" value="Male" class="mr-2" v-if="value==='m'" />
                                        <Tag severity="primary" value="Female" class="mr-2" v-else-if="value==='f'" />
                                        <Tag severity="primary" value="Others" class="mr-2" v-else-if="value==='o'" />
                                    </td>
                                </tr>
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

        <Dialog header="Bio"
                v-model:visible="store.display_bio_modal"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}"
                :modal="true"
        >
            <p class="m-3" v-html="store.bio_modal_data" />
        </Dialog>
    </div>

</template>
