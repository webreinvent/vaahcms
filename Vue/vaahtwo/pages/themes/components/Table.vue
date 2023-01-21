<script setup>

import { ref } from "vue";
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useThemeStore } from '../../../stores/store-themes'

const store = useThemeStore();
const useVaah = vaah();


const menu_options = ref();
const hideThemes = ref();
const toggle = ref();

</script>

<template>

    <div v-if="store.list">

        <!--table-->
         <DataTable :value="store.list"
                       dataKey="id"
                   class="p-datatable-sm"
                   v-model:selection="store.action.items"
                   stripedRows
                   responsiveLayout="scroll">

            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em">
            </Column>

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true">
            </Column>

            <Column field="name" header="Theme" :sortable="true">

                <template #body="prop">
                    <h3 class="title is-5 has-margin-bottom-10">{{ prop.data.name }} <Tag v-if="prop.data.is_default" value="Default" severity="success" class="ml-2" rounded></Tag></h3>
                    <div>{{ prop.data.excerpt }}</div>
                    <Tag class="mb-2 mt-2 bg-black-alpha-90 border-noround">Name:</Tag>
                    <Tag class="mt-2 border-noround" v-if="prop.data.name"> {{ prop.data.name }}</Tag>
                    <Tag class="ml-2 mb-2 mt-2 bg-black-alpha-90 border-noround">Version:</Tag>
                    <Tag class="mt-2 border-noround" v-if="prop.data.version">{{ prop.data.version }}</Tag>
                    <Tag class="ml-2 mb-2 mt-2 bg-black-alpha-90 border-noround">Developed by:</Tag>
                    <Tag class="mb-2 mt-2 border-noround" v-if="prop.data.author_name">{{ prop.data.author_name }}</Tag>
                </template>
            </Column>

             <Column>
                 <template #body="prop" class="control">
                     <span class="p-buttonset template">
                         <Button v-if="prop.data.is_active"
                               class="p-button-sm bg-yellow-300 text-900"
                               @click="store.toggleIsActive(prop.data)">
                             Deactivate
                         </Button>

                         <Button v-if="!prop.data.is_active"
                               class="p-button-sm bg-green-400"
                               @click="store.toggleIsActive(prop.data)">
                             Activate
                         </Button>
                         <Button v-if="prop.data.is_active && prop.data.is_default"
                                 v-tooltip.top="'This theme is marked as default'"
                                 icon="pi pi-check"
                                 class="bg-green-300  p-button-sm">
                         </Button>
                         <Button v-if="prop.data.is_active && !prop.data.is_default"
                             size="is-small"
                            class="p-button-sm bg-green-400"
                             v-tooltip.top="'Mark this theme as Default'"
                             @click="store.itemAction('make_default', prop.data)">
                            Make Default
                         </Button>
                         <Button v-if="prop.data.is_active"
                                  size="is-small"
                                  class="p-button-sm bg-yellow-300"
                                  icon="pi pi-database"
                                  @click="store.itemAction('import_sample_data', prop.data)">
                         </Button>
                         <Button class="p-button-danger p-button-sm"
                                 data-testid="themes-table-action-trash"
                                 v-if="!prop.data.deleted_at"
                                 @click="store.confirmDeleteItem(prop.data)"
                                 v-tooltip.top="'Trash'"
                                 icon="pi pi-trash" />

                         <Button class="p-button-outlined p-button-sm"
                                 data-testid="themes-table-to-view"
                                 v-tooltip.top="'View'"
                                 @click="store.toView(prop.data)"
                                 icon="pi pi-eye" />
                    </span>
                 </template>
             </Column>
        </DataTable>
        <!--/table-->

        <Divider />

        <!--paginator-->
        <Paginator v-model:rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
        <!--/paginator-->
    </div>
</template>
