<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import { onMounted, ref, watch } from "vue";
import { useRoute } from 'vue-router';
import { useUserStore } from '../../stores/store-users'
import { useRootStore } from "../../stores/root";
import { vaah } from '../../vaahvue/pinia/vaah';
import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';

const root = useRootStore();
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

    if (!store.item) {
        await store.getItem(route.params.id);
    }

    if (root.assets && root.assets.language_strings && root.assets.language_strings.crud_actions
        && store.assets && store.assets.language_strings)
    {
        await store.getItemMenu();
    }

});

//--------toggle item menu
const item_menu_state = ref();
const toggleItemMenu = (event) => {
    item_menu_state.value.toggle(event);
};
//--------/toggle item menu

watch(
    () => root.assets && store.assets,
     async () => {
        if (root.assets && root.assets.language_strings && root.assets.language_strings.crud_actions
            && store.assets && store.assets.language_strings)
        {
            await store.getItemMenu();
        }
    }
)

</script>
<template>
    <div class="col-5" >
        <Panel v-if="store.item" class="vc-dense">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="font-semibold vc-text-16">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <InputGroup>
                    <Button size="small" class="" :label=" '#' + store.item.id " @click="useVaah.copy(store.item.id)" data-testid="user-item_id" />

                    <Button size="small" :label="root.assets.language_strings.crud_actions.view_edit" @click="store.toEdit(store.item)" icon="pi pi-pencil" class="" data-testid="user-item_edit" v-if="store.hasPermission('can-update-users') || store.hasPermission('can-manage-users')" />

                    <!--item_menu-->
                    <Button size="small" class="" @click="toggleItemMenu" icon="pi pi-angle-down" aria-label="Show actions menu" aria-haspopup="true" data-testid="user-item_menu" v-if="store.hasPermission('can-update-users') || store.hasPermission('can-manage-users')" />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true"
                    />
                    <!--/item_menu-->

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" data-testid="user-list_view" @click="store.toList()" />
                </InputGroup>
            </template>

            <div v-if="store.item" class="mt-2">
                <Message severity="error"
                         class="p-container-message"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item.deleted_at"
                >

                    <div class="flex align-items-center justify-content-between"
                         v-if="root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions"
                    >
                        <div class="">
                            {{root.assets.language_strings.crud_actions.view_deleted}} {{store.item.deleted_at}}
                        </div>

                        <div class="ml-3">
                            <Button size="small" :label="root.assets.language_strings.crud_actions.view_restore" class="" data-testid="user-item_restore" @click="store.itemAction('restore')" />
                        </div>
                    </div>
                </Message>

                <div class="p-datatable p-component users-item-stripes">
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
                                        <Button size="small" class="p-button-secondary p-button-outlined p-button-rounded" label="View" icon="pi pi-eye" data-testid="user-item_bio_modal" @click="store.displayBioModal(value)" v-if="value" />
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

<style scoped>
/* M6-T5 (F23) — F11 R3.6 explicit local replacement for the v3 striped-row
   style class on this hand-rolled view table. The table is plain DOM (no
   <DataTable> component), so the `stripedRows` prop has no host to attach to
   and the v4 engine's striped rule — which targets a row class the DataTable
   emits on its own rows — cannot match hand-rolled rows. The v3
   `tr:nth-child(odd)` selector is therefore kept as a local style, and the
   background is bound to the v4 `datatable.row.striped.background` token —
   emitted as `--p-datatable-row-striped-background` (scheme-aware via the
   `.app-dark` darkModeSelector) — the same value the engine styles
   `stripedRows` DataTable rows with, so the stripe is identical to a
   `stripedRows` DataTable in both light and dark (D3 visual parity).
   This is the pattern M6-T2 (F21) applied to pages/modules/Item.vue. */
.users-item-stripes :deep(tr:nth-child(odd)) {
    background: var(--p-datatable-row-striped-background);
}
</style>
