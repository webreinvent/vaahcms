<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useMediaStore } from '../../../stores/store-media'

const store = useMediaStore();
const useVaah = vaah();

</script>

<template>

    <div v-if="store.list">
        <!--table-->
         <DataTable :value="store.list.data"
                       dataKey="id"
                   class="p-datatable-sm p-datatable-hoverable-rows"
                   v-model:selection="store.action.items"
                   stripedRows
                   responsiveLayout="scroll"
         >
            <Column selectionMode="multiple"
                    v-if="store.isViewLarge() || store.hasPermission('can-update-media')"
                    headerStyle="width: 3em"
            />

            <Column field="id" :sortable="true" header="ID" :style="{width: store.getIdWidth()}" />

             <Column field="thumbnail" header="Thumbnail">
                 <template #body="prop" >

                     <Image v-if="prop.data.type === 'image' && prop.data.url_thumbnail"
                            :src="prop.data.url_thumbnail" />

                     <img v-else-if="prop.data.type !== 'image'"
                          :src="store.file_image_url"
                          :alt="store.item.name"
                          width="100"
                          style="border-radius: 50%;"
                     />

                     <i v-else class="pi pi-file"></i>
                 </template>
             </Column>

            <Column field="file" header="File">
                <template #body="prop">
                    <table>
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
                    </table>
                </template>
            </Column>

            <Column field="updated_at" header="Updated"
                    :sortable="true"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
            >
                <template #body="prop">
                    {{useVaah.ago(prop.data.updated_at)}}
                </template>
            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()"
            >
                <template #body="prop">
                    <div class="p-inputgroup">
                        <Button class="p-button-tiny p-button-text"
                                data-testid="media-table-open-image"
                                v-tooltip.top="'Open Image'"
                                icon="pi pi-external-link"
                                value="Open"
                                url="prop.data.url"
                                @click="store.openImage(prop.data.url)"
                                target="_blank"
                        />

                        <Button class="p-button-tiny p-button-text"
                                data-testid="media-table-to-view"
                                v-tooltip.top="'View'"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye"
                                v-if="store.hasPermission('can-read-media')"
                        />

                        <Button class="p-button-tiny p-button-text"
                                data-testid="media-table-to-edit"
                                v-tooltip.top="'Update'"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil"
                                v-if="store.hasPermission('can-update-media')"
                        />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                data-testid="media-table-action-trash"
                                v-if="(store.isViewLarge() && !prop.data.deleted_at) || store.hasPermission('can-delete-media')"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash"
                        />

                        <Button class="p-button-tiny p-button-success p-button-text"
                                data-testid="media-table-action-restore"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="'Restore'"
                                icon="pi pi-replay"
                        />
                    </div>
                </template>
            </Column>
        </DataTable>
        <!--/table-->

        <Divider />

        <!--paginator-->
        <Paginator v-model:first="store.first_element"
                   :rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   class="bg-white-alpha-0 pt-2"
        >
        </Paginator>
        <!--/paginator-->
    </div>
</template>
