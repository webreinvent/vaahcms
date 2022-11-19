<script  setup>

import { onMounted,ref } from 'vue';
import { useRootStore } from "../../stores/root";
import { useDashboardStore } from "../../stores/dashboard";

const root = useRootStore();
const store = useDashboardStore();
const key = ref();

onMounted(async () => {
    root.verifyInstallStatus();
    await root.getAssets();
    await store.getItem();
});

</script>
<template>
    <div class="grid dashboard">
        <div class="col-12 md:col-8">

            <Card>
                <template #content>
                    <h5 class="text-xl font-semibold">Welcome to Vaah<b>cms</b></h5>
                    <p>We've assembled some links to get you started:</p>
                    <div class="grid mt-4">
                        <div class="col-12 md:col-4">
                            <h6 class="font-semibold mb-4">Get Started</h6>
                            <Button label="Go to Theme" />
                            <p class="text-sm mt-1">or,<a>create your own theme</a></p>
                        </div>

                        <div class="col-12 md:col-4">
                            <h6 class="font-semibold mb-4">Next Steps</h6>
                            <ul class="links-list">
                                <template v-if="store && store.dashboard_items && store.dashboard_items.success"
                                          v-for="module in store.dashboard_items.success"
                                >
                                    <template v-for="n_module in module.next_steps">
                                        <li>
                                            <a href="" @click="store.goToLink(n_item.link, n_item.open_in_new_tab ? n_item.open_in_new_tab : null)">
                                                <i class="pi" :class="n_module.icon"></i>
                                                {{ n_module.name }}
                                            </a>
                                        </li>
                                    </template>
                                </template>
                            </ul>
                        </div>

                        <div class="col-12 md:col-4">
                            <h6 class="font-semibold mb-4">More Actions</h6>
                            <ul class="links-list">
                                <template v-if="store && store.dashboard_items && store.dashboard_items.success"
                                          v-for="module in store.dashboard_items.success"
                                >
                                    <template v-for="n_module in module.actions">
                                        <li>
                                            <a href="" @click="store.goToLink(n_item.link, n_item.open_in_new_tab ? n_item.open_in_new_tab : null)">
                                                <i class="pi" :class="n_module.icon"></i>
                                                {{ n_module.name }}
                                            </a>
                                        </li>
                                    </template>
                                </template>
                            </ul>
                        </div>

                        <Divider></Divider>

                        <template v-if="store && store.dashboard_items && store.dashboard_items.success"
                                  v-for="module in store.dashboard_items.success"
                        >
                            <div class="col-12" v-if="module.card">
                                <h5 class="text-lg font-semibold mb-4">{{ module.card.title }}</h5>

                                <div class="grid m-0">
                                    <template v-for="(item, key) in module.card.list"
                                              v-if="(key+1)%4 !== 0"
                                    >
                                        <div class="col">
                                            <span class="p-3 border-circle" :class="item.css_class">
                                                <i class="text-blue-400 pi" :class="item.icon"></i>
                                            </span>

                                            <p class="text-sm font-semibold mt-3">{{ item.label }}</p>
                                            <h6 class="text-xl font-semibold my-1">{{ item.count }}</h6>
                                            <a href="" @click="store.goToLink(item.link, item.open_in_new_tab ? item.open_in_new_tab : null)"
                                               class="text-sm">
                                                View Details
                                            </a>
                                        </div>

                                        <Divider layout="vertical" class="hidden md:block"></Divider>
                                        <Divider class="md:hidden"></Divider>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </Card>
        </div>

        <div class="col-12 md:col-4 mt-3">
            <template v-if="store && store.dashboard_items && store.dashboard_items.success"
                      v-for="module in store.dashboard_items.success"
            >
                <template v-if="module.expanded_header_links"
                          v-for="h_item in module.expanded_header_links"
                >
                    <Button :label="h_item.name"
                            :icon="h_item.icon"
                            class="p-button-sm p-button-outlined mr-2 mb-3 pi"
                    />
                </template>
            </template>

            <template v-if="store && store.dashboard_items && store.dashboard_items.success">
                <template v-for="module in store.dashboard_items.success">
                    <Accordion :multiple="true"
                               :activeIndex="store.active_index"
                    >
                        <template v-for="item in module.expanded_item">
                            <AccordionTab  :header="item.title">
                                <div v-if="item.type == 'content'">
                                    <div v-if="!item.is_job_enabled">
                                        <Message class="bg-red-50 text-red-400"
                                                 :closable="false"
                                                 icon="null"
                                        >
                                            Enable <b>Laravel Queues</b> to run your jobs
                                            <a @click="store.goToLink(root.current_url+'#/vaah/settings/general')"
                                               href=""
                                            >
                                                View Setting
                                            </a>
                                        </Message>
                                    </div>

                                    <p class="text-sm">l
                                        {{ item.description }}
                                    </p>
                                    <Divider></Divider>

                                    <div class="flex justify-content-evenly align-items-center align-items-center">
                                        <template v-for="f_item in item.footer">
                                            <a href="" class="text-center" @click="store.goToLink(f_item.link)">
                                                <i class="mr-2 pi" :class=" 'pi-' + f_item.icon"></i>
                                                {{ f_item.count }} {{ f_item.name }}
                                            </a>

                                            <Divider layout="vertical"></Divider>
                                        </template>
                                    </div>
                                </div>

                                <div v-if="item.type === 'list' ">
                                    <div v-for="(log,l_index) in item.list">
                                        <div class="flex justify-content-between">
                                            <p class="text-sm text-red-500">
                                                {{ log.name }}
                                            </p>

                                            <a href=""
                                               @click="store.goToLink(item.link+'details/'+log.name)"
                                               class="text-sm"
                                            >
                                                View
                                            </a>
                                        </div>
                                    </div>

                                    <div v-if="item.list.length === 0">
                                        <div class="card-content">
                                            <div class="notification is-small is-success is-light">
                                                {{ item.empty_response_note }}
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="item.list.length > item.list_limit" class="card-footer">
                                        <div class="card-footer-item" >
                                            <a @click="store.goToLink(item.link)">{{ item.link_text }}</a>
                                        </div>

                                    </div>
                                </div>
                            </AccordionTab>
                        </template>
                    </Accordion>
                </template>
            </template>
        </div>
    </div>

</template>


