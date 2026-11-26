<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useTaxonomyStore } from '../../../stores/store-taxonomies'
import {useRootStore} from "../../../stores/root";
const root = useRootStore();
const store = useTaxonomyStore();
const useVaah = vaah();

// UT-90 (M6-T4a Batch 17) — the "Manage taxonomy type" action moved from
// every row's Type cell to the panel header (List.vue), so the dialog
// host and the opener live on the same component now.

</script>

<template>
    <div v-if="store.list && store.assets">
        <!--table-->
         <DataTable size="small" rowHover :value="store.list.data" dataKey="id" class="" v-model:selection="store.action.items" stripedRows scrollable>
            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em"
            />

            <Column field="id"
                    header="ID"
                    :style="{ width: store.getIdWidth() }"
                    :sortable="true"
            />
             <Column field="name" header="Name"
                     :sortable="true"
             >
                 <template #body="prop">
                     <Badge v-if="prop.data.deleted_at"
                            value="Trashed"
                            severity="danger"
                     />
                     {{ prop.data.name }}
                 </template>
             </Column>



            <Column field="slug" header="Slug"
                    :sortable="false"
            >
                <template #body="prop">
                    <div class="flex align-items-center">
                        <!-- UT-90 (M6-T4a Batch 17) — this button shared the
                             `taxonomies-table-to-edit` testid with the row's
                             own Edit button, so a `data-testid` locator
                             matched two elements in every row. -->
                        <Button aria-label="Copy slug" class="p-button-tiny p-button-text p-0 mr-2 vaah-icon-action"
                                data-testid="taxonomies-table-copy-slug"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_copy_slug"
                                @click="useVaah.copy(prop.data.slug)"
                                icon="pi pi-copy"
                        />
                        <p v-if="prop.data.slug">{{ prop.data.slug }}</p>
                    </div>
                </template>
            </Column>
             <Column field="type" header="Type"
                     :sortable="false"
             >
                 <template #body="prop">
                     <!-- UT-90 (M6-T4a Batch 17) — the "Manage taxonomy
                          type" pencil used to sit in *every* row's Type
                          cell, right next to the row's own Edit pencil:
                          two identical pencils in one row, and the first
                          one did not even act on the row (it opens the
                          global type manager). It now lives once, in the
                          panel header. -->
                     <p v-if="prop.data.type"> {{ prop.data.type.name }} </p>
                     <span v-else class="vaah-empty-value">—</span>
                 </template>
             </Column>

            <Column field="updated_at" header="Updated"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
                    :sortable="true"
            >
                <template #body="prop">
                    <!-- UT-88 (M6-T4a Batch 17) — every seeded taxonomy
                         carries `updated_at = NULL`, so the cell rendered
                         *empty* and the column looked broken rather than
                         empty. -->
                    <span v-if="prop.data.updated_at">{{ useVaah.ago(prop.data.updated_at) }}</span>
                    <span v-else class="vaah-empty-value">—</span>
                </template>
            </Column>

            <Column field="is_active" v-if="store.isViewLarge()"
                    :sortable="false"
                    style="width:100px;"
                    header="Is Active"
            >
                <template #body="prop">
                    <ToggleSwitch v-model.bool="prop.data.is_active"
                                 data-testid="taxonomies-table-is-active"
                                 :aria-label="'Toggle active status for ' + (prop.data.slug || '')"
                                 v-bind:false-value="0"
                                 v-bind:true-value="1"
                                
                                 @input="store.toggleIsActive(prop.data)"
                    />
                </template>
            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
                    v-if="root.assets
                          && root.assets.language_strings
                          && root.assets.language_strings.crud_actions"
            >
                <template #body="prop">
                    <InputGroup>

                        <Button aria-label="View taxonomy" class="p-button-tiny p-button-text"
                                data-testid="taxonomies-table-to-view"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                                @click="store.toView(prop.data)"
                                v-if="store.hasPermission('can-read-taxonomies')"
                                icon="pi pi-eye"
                        />

                        <Button aria-label="Edit taxonomy" class="p-button-tiny p-button-text"
                                data-testid="taxonomies-table-to-edit"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_update"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil"
                                v-if="store.hasPermission('can-update-taxonomies')"
                        />

                        <Button aria-label="Delete taxonomy" class="p-button-tiny p-button-danger p-button-text"
                                data-testid="taxonomies-table-action-trash"
                                v-if="(store.isViewLarge() && !prop.data.deleted_at) || store.hasPermission('can-delete-taxonomies')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash"
                                icon="pi pi-trash"
                        />

                        <Button aria-label="Restore taxonomy" class="p-button-tiny p-button-success p-button-text"
                                data-testid="taxonomies-table-action-restore"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_restore"
                                icon="pi pi-replay"
                        />
                    </InputGroup>
                </template>
            </Column>
             <!-- M7-T3 (F26) — the v4 engine renders a blank cell when the
                  #empty slot is absent, so the slot says what to do next
                  (DESIGN-SYSTEM §8): a muted line + one primary action. -->
             <template #empty>
                 <div class="vaah-empty" data-testid="taxonomies-list_empty">
                     <i class="vaah-empty-icon pi pi-tags" aria-hidden="true"></i>
                     <p class="vaah-empty-copy">No taxonomies match your search — reset the filters, or create a new taxonomy.</p>
                     <Button class="vaah-btn-primary" :label="root.assets.language_strings.crud_actions.create_button" icon="pi pi-plus" @click="store.toForm()" data-testid="taxonomies-list_empty_create" v-if="store.hasPermission('can-create-taxonomies')" />
                 </div>
             </template>
        </DataTable>
        <!--/table-->


        <!--paginator-->
        <Paginator v-model:first="store.first_element"
                   :rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   class="bg-white-alpha-0 pt-2"
        />
        <!--/paginator-->
    </div>
</template>

<!--
    M5-T4 (F19) — the v3 toggle-switch CSS override block that used to sit
    here is REMOVED, not re-tokenized:

    * It was DEAD. OpenVue v4 renders the toggle with the `p-toggleswitch*`
      DOM classes (the v3 switch component is only an alias of the v4
      `ToggleSwitch`), so no element in this table ever carried the v3 switch
      classes — the four hex literals were styling nothing.
    * It was UNSCOPED, so it leaked a hard-coded palette into the global
      stylesheet.
    * The checked state it wanted (a green slider) is already produced by the
      theme: the OpenVue preset emits the checked slider background from the
      semantic success token, and `scss/style/style.scss` (UT-9, M6-T4a)
      repeats it unlayered, so the slider is scheme-aware green in light AND
      dark with no raw hex anywhere. Peer surfaces (users / roles /
      permissions tables) carry no such override — deleting this block
      restores that parity.
-->
