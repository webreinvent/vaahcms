<script  setup>

import { useModuleStore } from '../../../stores/store-modules'
import VhFieldVertical from './../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue'

const store = useModuleStore();

</script>

<template>
    <div v-if="store.hasPermission('can-update-theme')">

        <Sidebar v-model:visible="store.show_filters"
                 position="right">
            <VhFieldVertical>
                <template #label>
                    <b>Is Active:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="active-all"
                                 value="all"
                                 data-testid="modules-filters-status-all"
                                 v-model="store.query.status" />
                    <label for="active-all">All</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-true"
                                 data-testid="modules-filters-status-active"
                                 value="active"
                                 v-model="store.query.status" />
                    <label for="active-true">Active</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-false"
                                 data-testid="modules-filters-status-inactive"
                                 value="inactive"
                                 v-model="store.query.status" />
                    <label for="active-false">Inactive</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-false"
                                 data-testid="modules-filters-status-update-available"
                                 value="update_available"
                                 v-model="store.query.status" />
                    <label for="active-false">Update Available</label>
                </div>

            </VhFieldVertical>
        </Sidebar>

    </div>
</template>
