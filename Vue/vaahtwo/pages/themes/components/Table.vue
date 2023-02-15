<script setup>

import { ref } from "vue";
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useThemeStore } from '../../../stores/store-themes'
import { useConfirm } from "primevue/useconfirm";

const store = useThemeStore();
const useVaah = vaah();


const menu_options = ref();
const hideThemes = ref();
const toggle = ref();

const confirm = useConfirm();

const importSampleDataModal = (item) => {
    confirm.require({
        message: 'This will import sample/dummy data of the theme <b>' + item.name + '</b>. This action cannot be undone.',
        header: 'Importing Sample Data',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
            store.itemAction('import_sample_data', item);
        },
    });
}
</script>

<template>

    <div v-if="store.list">
        <div class="col-12" v-for="item in store.list">
            <div class="grid">
                <div class="col-12 md:col-5">
                    <h5 class="font-semibold text-xl inline">{{ item.name }}</h5>
                    <Tag v-if="item.is_default" value="Default" severity="success" class="ml-2" rounded></Tag>
                    <p class="text-sm text-gray-600 mt-2">{{ item.description }}</p>
                </div>
                <div class="col-12 md:col-7">
                    <div class="flex justify-content-end mb-3">
                        <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold"
                             :value=" 'Name: ' + item.name "
                        />

                        <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold"
                             :value=" 'Version: ' + item.version "
                        />

                        <Tag class="mr-2 bg-blue-50 text-blue-600 font-semibold"
                             :value=" 'Developed by: ' + item.author_name "
                        />
                    </div>

                    <div class="flex justify-content-end">
                        <Button v-if="item.is_active && store.hasPermission('can-deactivate-theme')"
                                class="mr-2 p-button-sm"
                                @click="store.toggleIsActive(item)"
                                data-testid="themes-table-action-deactivate"
                                label="Deactivate"
                        />

                        <Button v-if="!item.is_active && store.hasPermission('can-activate-theme')"
                                class="mr-2 p-button-sm"
                                @click="store.toggleIsActive(item)"
                                data-testid="themes-table-action-activate"
                                label="Activate"
                        />

                        <Button v-if="store.hasPermission('can-activate-theme') && item.is_active && item.is_default"
                                v-tooltip.top="'This theme is marked as default'"
                                icon="pi pi-check"
                                data-testid="themes-table-action-is_default_marked"
                                class="mr-2 p-button-warning p-button-sm"
                        />

                        <Button v-if="store.hasPermission('can-activate-theme') && item.is_active && !item.is_default"
                                class="mr-2 p-button-sm"
                                v-tooltip.top="'Mark this theme as Default'"
                                data-testid="themes-table-action-mark_default"
                                @click="store.itemAction('make_default', item)"
                                label="Make Default"
                        />

                        <Button v-if="item.is_active && store.hasPermission('can-import-sample-data-in-theme')"
                                class="mr-2 p-button-sm"
                                icon="pi pi-database"
                                data-testid="themes-table-action-import_sample_data"
                                @click="importSampleDataModal(item)"
                        />

                        <Button class="mr-2 p-button-danger p-button-sm"
                                v-if="!item.deleted_at && store.hasPermission('can-update-theme')"
                                @click="store.confirmDeleteItem(item)"
                                data-testid="themes-table-action-delete"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash" />
                    </div>
                </div>
            </div>
            <Divider />
        </div>

        <!--paginator-->
        <Paginator v-model:rows="store.query.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   data-testid="themes-list-pagination"
                   :rowsPerPageOptions="store.rows_per_page">
        </Paginator>
        <!--/paginator-->

        <ConfirmDialog group="templating" class="is-small"
                       :style="{width: '400px'}"
                       :breakpoints="{'600px': '100vw'}"
        >
            <template #message="slotProps">
                <div class="flex">
                    <i :class="slotProps.message.icon" style="font-size: 1.5rem"></i>
                    <p class="pl-2 text-sm">{{ slotProps.message.message }}</p>
                </div>
            </template>
        </ConfirmDialog>
    </div>
</template>
