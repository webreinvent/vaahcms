<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useMediaStore } from '../../../stores/store-media'
import {useRootStore} from "../../../stores/root";

const root = useRootStore();
const store = useMediaStore();
const useVaah = vaah();

</script>

<template>

    <div v-if="store.list && store.assets">
        <!--table-->
         <DataTable size="small" rowHover :value="store.list.data" dataKey="id" class="" v-model:selection="store.action.items" stripedRows scrollable>
            <Column selectionMode="multiple"
                    v-if="store.isViewLarge() || store.hasPermission('can-update-media')"
                    headerStyle="width: 3em"
            />

            <Column field="id" :sortable="true" header="ID" :style="{width: store.getIdWidth()}" />

             <Column field="thumbnail" header="Thumbnail">
                 <template #body="prop" >

                     <!-- M6-T1 — every row's thumbnail is the *same*
                          45px circle: the real image when the media has a
                          thumbnail, the local file glyph when it does not.
                          The three cases used to render three different
                          things — a natural-size image, a bare unframed
                          icon, and a picture fetched from a third-party
                          icon host — so the column read as three columns.

                          The fallback thumbnail also read `store.item.name`
                          (the *selected* item, which is null on the list
                          screen), so a non-image file in the library threw
                          on it.

                          The image is decorative (`alt=""`): an <img> whose
                          source cannot be loaded paints its alt text
                          *inside* the box and that text is not clipped by
                          the box, so it spilled over the row's other
                          columns. The file name is already in the "File"
                          column of the same row.

                          The file glyph sits *under* the image, so a
                          failed load leaves the local glyph rather than an
                          empty circle — and no third-party host is
                          contacted at all. -->
                     <span class="media-list-thumb">
                         <i class="pi pi-file media-thumb-fallback"
                            aria-hidden="true"></i>
                         <Image v-if="prop.data.type === 'image' && prop.data.url_thumbnail"
                                :src="prop.data.url_thumbnail"
                                alt=""
                         />
                     </span>
                 </template>
             </Column>

            <Column field="file" header="File">
                <template #body="prop">
                    <!-- M6-T1 — the v4 engine's rule `.p-datatable tr th`
                         (font-size: .7rem) reaches *any* table nested inside
                         a DataTable, so the labels of this inner table were
                         rendered at 9.8px — far below the type scale and
                         next to 14px values. The inner table carries its
                         own class now and the label column is set back
                         onto the scale (13px, muted). -->
                    <table class="media-file-details">
                        <tbody>
                            <tr>
                                <th width="80">Name</th>
                                <td>{{ prop.data.name }}</td>
                            </tr>
                            <tr v-if="prop.data.title">
                                <th width="80">Title</th>
                                <td>{{ prop.data.title }}</td>
                            </tr>
                            <tr>
                                <th width="80">Details</th>
                                <td>
                                    <Tag class="mr-2">{{ (prop.data.size / 1024).toFixed(2) }} kb</Tag>
                                    <Tag>{{ prop.data.mime_type }}</Tag>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </template>
            </Column>

            <Column field="updated_at" header="Updated"
                    :sortable="true"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
            >
                <template #body="prop">
                    <!-- UT-88 (M6-T4a Batch 17) — a media row that has
                         never been touched carries `updated_at = NULL`, so
                         the cell rendered *empty* and the column looked
                         broken rather than empty. -->
                    <span v-if="prop.data.updated_at">{{useVaah.ago(prop.data.updated_at)}}</span>
                    <span v-else class="vaah-empty-value">—</span>
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
                        <Button aria-label="Open image" class="p-button-tiny"
                                text
                                data-testid="media-table-open-image"
                                v-tooltip.top="store.assets.language_strings.toolkit_text_open_image"
                                icon="pi pi-external-link"
                                @click="store.openImage(prop.data.url)"
                        />

                        <Button aria-label="View media" class="p-button-tiny"
                                text
                                data-testid="media-table-to-view"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_view"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye"
                                v-if="store.hasPermission('can-read-media')"
                        />

                        <Button aria-label="Edit media" class="p-button-tiny"
                                text
                                data-testid="media-table-to-edit"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_update"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil"
                                v-if="store.hasPermission('can-update-media')"
                        />

                        <Button aria-label="Delete media" class="p-button-tiny"
                                severity="danger"
                                text
                                data-testid="media-table-action-trash"
                                v-if="(store.isViewLarge() && !prop.data.deleted_at) || store.hasPermission('can-delete-media')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash"
                                icon="pi pi-trash"
                        />

                        <Button aria-label="Restore media" class="p-button-tiny"
                                severity="success"
                                text
                                data-testid="media-table-action-restore"
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
                 <div class="vaah-empty" data-testid="media-list_empty">
                     <i class="vaah-empty-icon pi pi-image" aria-hidden="true"></i>
                     <p class="vaah-empty-copy">No media files match your search — upload a file, or reset the filters.</p>
                     <Button class="vaah-btn-primary" :label="root.assets.language_strings.crud_actions.create_button" icon="pi pi-plus" @click="store.toForm()" data-testid="media-list_empty_create" v-if="store.hasPermission('can-create-media')" />
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
                   class="pt-2"
        >
        </Paginator>
        <!--/paginator-->
    </div>
</template>

<style scoped>
/* M6-T1 — the v4 engine's rule `.p-datatable tr th { font-size: .7rem }`
   reaches every table nested inside a DataTable, so the labels of the
   inner "File" table were rendered at 9.8px. The selector below carries
   one class more than the engine's, so it wins on specificity without an
   `!important`. */
.p-datatable .media-file-details th {
    font-size: 13px;
    line-height: 1.4;
    font-weight: 600;
    color: var(--p-text-muted-color);
}

/* M6-T1 (D4) — the sortable column's indicator.
   The engine sizes the sort glyph from its `datatable.sort.icon.size`
   token (0.75rem = 10.5px at the 14px root): a 10 × 10.5px mark floating
   next to the 14px column title, which read as a stray glyph rather than
   as a sort affordance. It is set to the title's own 14px, which keeps
   the column header on one baseline.

   The rule carries the scoped attribute, so it out-specifies the engine's
   own `.p-datatable-sort-icon` rule (which lives in the library layer and
   is outranked by any unlayered app rule). */
.p-datatable :deep(.p-datatable-sort-icon) {
    width: 14px;
    height: 14px;
    font-size: 14px;
}

/* M6-T1 — the non-image file icon: a fixed 45px circle that clips its
   content, so a failed image load cannot stretch the row. */
.media-list-thumb {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    overflow: hidden;
    border-radius: 50%;
    background: var(--p-content-hover-background);
}

/* M6-T1 — the thumbnail image fills the same circle. The engine's `Image`
   component renders at its natural size by default, so without this the
   real thumbnail was drawn at whatever size the file happened to be. */
.media-list-thumb :deep(.p-image) {
    position: relative;
    display: block;
    width: 45px;
    height: 45px;
    overflow: hidden;
    border-radius: 50%;
}

.media-list-thumb :deep(.p-image img) {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* M6-T1 — the local file glyph, painted under the thumbnail so a failed
   image load leaves the glyph instead of an empty circle. */
.media-thumb-fallback {
    position: absolute;
    font-size: 16px;
    color: var(--p-text-muted-color);
}
</style>
