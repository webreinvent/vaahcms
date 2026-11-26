<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';
import { useRegistrationStore } from '../../stores/store-registrations'
import { useRootStore } from "../../stores/root";
import { vaah } from '../../vaahvue/pinia/vaah'
import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';

const root = useRootStore();
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
        <Panel v-if="store && store.item" class="vc-dense">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="p-panel-title">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <InputGroup>
                    <Button size="small" class="" :label=" '#' + store.item.id " @click="useVaah.copy(store.item.id)" data-testid="registration-item_id" />

                    <Button size="small" :label="root.assets.language_strings.crud_actions.view_edit" class="" @click="store.toEdit(store.item)" icon="pi pi-pencil" data-testid="register-view_to_edit" v-if="store.hasPermission('can-update-registrations') && root.assets && root.assets.language_strings && root.assets.language_strings.crud_actions" />

                    <!--item_menu-->
                    <Button size="small" class="" @click="toggleItemMenu" icon="pi pi-angle-down" aria-label="Show actions menu" aria-haspopup="true" data-testid="register-view_toggle_item_menu_list" v-if="store.hasPermission('can-update-registrations') || store.hasPermission('can-manage-registrations')" />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true" />

                    <!--/item_menu-->

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" @click="store.toList()" data-testid="register-view_to_list" />
                </InputGroup>
            </template>

            <div v-if="store.item" class="mt-2">
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

                        <div class="">
                            <Button size="small" :label="root.assets.language_strings.crud_actions.view_restore" class="" @click="store.itemAction('restore')" data-testid="register-view_item_action_to_restore" />
                        </div>
                    </div>
                </Message>

                <div class="p-datatable p-component register-item-stripes">
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
                                           data-testid="register-view_copy_identity"
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
                                           data-testid="register-view_copy_profile"
                                           v-if="!store.isHidden(column)"
                                />
                            </template>

                            <template v-else-if="column === 'birth' || column === 'foreign_user_id' ||
                                                 column === 'display_name'"
                            >
                                <VhViewRow :label="column"
                                           :value="value"
                                           :can_copy="false"
                                           data-testid="register-view_copy_details"
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
                                        <Button size="small" class="p-button-secondary p-button-outlined p-button-rounded" label="View" icon="pi pi-eye" @click="store.displayBioModal(value)" v-if="value" />
                                    </td>
                                </tr>
                            </template>

                            <template v-else-if="column === 'meta'">
                                <tr>
                                    <td><b>Meta</b></td>
                                    <td v-if="value">
                                        <Button size="small" icon="pi pi-eye" label="view" class="p-button-outlined p-button-secondary p-button-rounded" @click="store.openModal(value)" data-testid="register-open_meta_modal" />
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
                                        <InputGroup>
                                            <Button :label="value"
                                                    v-if="value"
                                                    class="p-button-outlined p-button-secondary p-button-xs"
                                                    disabled="disabled"
                                            />

                                            <Button aria-label="Show status menu" v-if="store.assets && store.assets.registration_statuses"
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


                                            <Button aria-label="Show status menu" v-if="value == 'email-verified'"
                                                    type="button"
                                                    @click="toggleUserStatusMenu"
                                                    icon="pi pi-angle-down"
                                                    aria-haspopup="true"
                                                    class="p-button-success p-button-xs"
                                                    data-testid="register-view_email_verified"
                                            />


                                        </InputGroup>
                                    </td>
                                </tr>
                            </template>

                            <template v-else-if="column === 'gender'">
                                <tr v-if="!store.isHidden(column)">
                                    <td><b>Gender</b></td>
                                    <td v-if="value">
                                        <Tag severity="info" value="Male" class="mr-2" v-if="value==='m'" />
                                        <Tag severity="info" value="Female" class="mr-2" v-else-if="value==='f'" />
                                        <Tag severity="info" value="Others" class="mr-2" v-else-if="value==='o'" />
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

<style scoped>
/* M4-T1 (F13) — local replacement for the removed v3 `p-datatable-striped`
   class (zero rules for it in the emitted v4 CSS — dead) on this
   hand-rolled field view table. The table is plain DOM (no <DataTable>
   component), so the `stripedRows` prop has no host to attach to, and the
   v4 engine's striped rule — which targets the `p-row-odd` row class the
   DataTable component emits on its own rows — cannot match hand-rolled
   rows. The v3 `tr:nth-child(odd)` selector is therefore kept as a local
   style, and the background is bound to the v4 `datatable.row.striped.
   background` token — the OpenVue theme emits it as
   `--p-datatable-row-striped-background` (Nide: surface.50 light / a
   surface.800 mix dark), scheme-aware via the `.app-dark` darkModeSelector
   — the same value the engine styles `stripedRows` DataTable rows with,
   so the stripe is identical to a `stripedRows` DataTable in both light
   and dark (D3 visual parity). Same pattern as `pages/modules/Item.vue`. */
.register-item-stripes :deep(tr:nth-child(odd)) {
    background: var(--p-datatable-row-striped-background);
}
</style>
