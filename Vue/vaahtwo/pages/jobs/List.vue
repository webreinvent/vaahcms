<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useJobStore} from '../../stores/store-jobs'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";

const store = useJobStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();


onMounted(async () => {
    /**
     * call onLoad action when List view loads
     */
    await store.onLoad(route);

    /**
     * watch routes to update view, column width
     * and get new item when routes get changed
     */
    await store.watchRoutes(route);

    /**
     * watch states like `query.filter` to
     * call specific actions if a state gets
     * changed
     */
    await store.watchStates();

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();

    /**
     * fetch job menu items
     */
    await store.getJobsMenuItems();

});


/**
 * toggle job menu
 */
const jobs_menu_items = ref();

const toggleJobMenu = (event) => {
    jobs_menu_items.value.toggle(event);
};

</script>
<template>

    <div class="grid">

        <div :class="'col-'+store.list_view_width">
            <Panel>

                <template class="p-1" #header>

                    <div class="flex flex-row">
                        <div >
                            <b class="mr-1">Jobs</b>
                            <Badge v-if="store.list && store.list.total > 0"
                                   :value="store.list.total">
                            </Badge>
                        </div>
                    </div>
                </template>

                <template #icons>

                    <div class="p-inputgroup">
                        <Button class="p-button-sm"
                                icon="pi pi-refresh"
                                :loading="store.is_btn_loading"
                                @click="store.getList()"
                        />

                        <!--/jobs menu-->
                        <Button class="p-button-sm"
                                icon="pi pi-ellipsis-v"
                                type="button"
                                aria-haspopup="true"
                                @click="toggleJobMenu"
                        />

                        <Menu ref="jobs_menu_items"
                              :model="store.jobs_menu_items"
                              :popup="true"
                        />
                        <!--/jobs menu-->
                    </div>
                </template>

                <Message severity="info" :closable="false">
                    This list consist of only queued/pending jobs.
                    Completed jobs gets deleted automatically .
                </Message>

                <Actions/>

                <br/>

                <Table/>
            </Panel>
        </div>

        <RouterView/>
    </div>
</template>
