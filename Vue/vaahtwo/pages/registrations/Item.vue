<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';


import { useRegistrationStore } from '../../stores/store-registrations'

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
const store = useRegistrationStore();
const route = useRoute();

onMounted(async () =>
{

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

//--------modal
const display_meta_modal = ref(false);
const openModal = () => {
            display_meta_modal.value = true;
};
const closeModal = () => {
            display_meta_modal.value = false;
}
//--------/modal

/*
const item_status=ref();
const statuses=ref([
                {
                    label: 'Email Verification Pending',
                    icon: 'pi pi-calendar-times',
                    command: async () => {
                        await store.updateList('email-verification-pending')
                    }
                },
                {
                    label: 'Email Verified',
                    icon: 'pi pi-envelope',
                    command: async () => {
                        await store.updateList('email-verified')
                    }
                },
                {
                    label: 'User Created',
                    icon: 'pi pi-user-plus',
                    command: async () => {
                        await store.updateList('user-created')
                    }
                },
])
const toggleStatusesMenu = (event) => {
    item_status.value.toggle(event);
};
*/









</script>
<template>

    <div class="col-4" >

        <Panel v-if="store && store.item" >

            <template class="p-1" #header>

                <div class="flex flex-row">

                    <div class="p-panel-title">
                        {{store.item.display_name}}
                    </div>

                </div>

            </template>

            <template #icons>


                <div class="p-inputgroup">
                    <Button>
                        #{{store.item.id}}
                    </Button>
                    <Button label="Edit"
                            @click="store.toEdit(store.item)"
                            icon="pi pi-save"
                            data-testid="register-view_to_edit"
                    />

                    <!--item_menu-->
                    <Button
                        type="button"
                        @click="toggleItemMenu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"
                        data-testid="register-view_toggle_item_menu_list"
                    />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true" />


                    <!--/item_menu-->


                    <Button class="p-button-primary"
                            icon="pi pi-times"
                            @click="store.toList()"
                            data-testid="register-view_to_list"
                    />


                </div>



            </template>


            <div v-if="store.item">

                <Message severity="error"
                         class="p-container-message"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item.deleted_at">

                    <div class="flex align-items-center justify-content-between">

                        <div class="">
                            Deleted {{store.item.deleted_at}}
                        </div>

                        <div class="">
                            <Button label="Restore"
                                    class="p-button-sm"
                                    @click="store.itemAction('restore')"
                                    data-testid="register-view_item_action_to_restore"
                                    >
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

                        <template v-else-if="column === 'id' || column === 'uuid'|| column === 'email' ||
                                             column === 'username' || column === 'phone' ||
                                             column === 'activation_code' ||column === 'alternate_email' " >
                            <VhViewRow :label="column"
                                       :value="value"
                                       :can_copy="true"
                                       data-testid="register-view_copy"
                            />
                        </template>

                        <template v-else-if="(column === 'created_by_user' || column === 'updated_by_user'  || column === 'deleted_by_user') && (typeof value === 'object' && value !== null)">
                            <VhViewRow :label="column"
                                       :value="value"
                                       type="user"
                                       data-testid="register-view_user_copy"
                            />
                        </template>

                        <template v-else-if="column === 'meta'">
                            <tr>
                                <td><b>Meta</b></td>
                                <td v-if="value">
                                    <Button icon="pi pi-eye"
                                            label="view"
                                            class="p-button-outlined p-button-secondary p-button-rounded p-button-sm"
                                            @click="openModal"
                                            data-testid="register-open_meta_modal"
                                    />
                                </td>
                            </tr>
                            <Dialog header="Meta"
                                    v-model:visible="display_meta_modal"
                                    :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                                    :style="{width: '50vw'}" :modal="true"
                            >
                                <p class="m-0">{{value}}</p>
                            </Dialog>

                            </template>


                        <template v-else-if="column === 'status'" >
                            <tr>
                                <td><b>Status</b></td>
                                <td v-if="value">
                                    <div class="p-inputgroup">
                                        <Button :label="value"
                                                v-if="value"
                                                class="p-button-outlined p-button-secondary p-button-sm"
                                                disabled="disabled"
                                        />
                                        <Dropdown
                                                  :options="store.assets.registration_statuses"
                                                  optionLabel="name"
                                                  optionValue="slug"
                                                  placeholder="- Select a status -"
                                                  @change="store.changeStatus($event.value)"
                                        />


<!--                                        <Button type="button"
                                                @click="toggleStatusesMenu"
                                                icon="pi pi-angle-down"
                                                aria-haspopup="true"
                                                class="p-button-outlined p-button-secondary"
                                                data-testid="register-view_toggle_registration_statuses"

                                        />
                                        <Menu v-if="store.assets && store.assets.registration_statuses"
                                                ref="item_status"
                                                :model="store.assets.registration_statuses"
                                                :popup="true" />-->


                                        <Button v-if="value == 'email-verification-pending'"
                                                label="Resend Verification Email"
                                                class="p-button-info p-button-sm"
                                                @click="store.sendVerificationEmail()"
                                                data-testid="register-view_send_verification_email"
                                        />
                                        <Button v-if="value == 'email-verified'"
                                                label="Create User"
                                                class="p-button-success p-button-sm"
                                                 @click="store.confirmCreateUser()"
                                                data-testid="register-view_confirm_create_user"
                                        />
                                        <Button v-if="value == 'email-verified'"
                                                type="button"
                                                @click=""
                                                icon="pi pi-angle-down"
                                                aria-haspopup="true"
                                                class="p-button-success"
                                                data-testid="register-view_email_verified"
                                        />


                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template v-else-if="column === 'status'" >
                            <tr>
                                <td><b>Status</b></td>
                                <td v-if="value">
                                    <div class="p-inputgroup">
                                        <Button :label="value"
                                                v-if="value"
                                                class="p-button-outlined p-button-secondary p-button-sm"
                                                disabled="disabled"
                                        />
<!--                                        <Button type="button"
                                                @click="toggleStatusesMenu"
                                                icon="pi pi-angle-down"
                                                aria-haspopup="true"
                                                class="p-button-outlined p-button-secondary"
                                                data-testid="register-view_toggle_registration_statuses"

                                        />
                                        <Menu v-if="store.assets && store.assets.registration_statuses"
                                                ref="item_status"
                                                :model="store.assets.registration_statuses"
                                                :popup="true" />-->
<!--                                        <Button type="button"
                                                label="Toggle"
                                                @click="toggle"
                                                aria-haspopup="true"
                                                aria-controls="overlay_menu"/>
                                        <Menu id="overlay_menu" ref="menu" :model="items" :popup="true" />-->
                                        <SplitButton label="Secondary"
                                         :model="statuses"
                                         class="p-button-outlined p-button-secondary mb-2">
                            </SplitButton>



                                    </div>
                                </td>
                            </tr>
                        </template>



                        <template v-else-if="column === 'gender'">
                            <tr>
                                <td><b>Gender</b></td>
                                <td v-if="value">
                                    <Badge severity="primary" class="mr-2" v-if="value=='m'">Male</Badge>
                                    <Badge severity="primary" class="mr-2" v-if="value=='f'">Female</Badge>
                                    <Badge severity="primary" class="mr-2" v-if="value=='o'">Others</Badge>
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

    </div>

</template>
