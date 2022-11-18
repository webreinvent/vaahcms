<script  setup>

import { onMounted } from 'vue';
import { useRootStore } from "../../stores/root";
import { useDashboardStore } from "../../stores/dashboard";

const root = useRootStore();
const store = useDashboardStore();

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
                                <li>
                                    <a><i class="pi pi-desktop"></i>View your site</a>
                                </li>
                                <li>
                                    <a><i class="pi pi-eye"></i>View Pages</a>
                                </li>
                                <li>
                                    <a><i class="pi pi-plus"></i>Add Pages</a>
                                </li>
                                <li>
                                    <a><i class="pi pi-pencil"></i>Add a Content Type</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-12 md:col-4">
                            <h6 class="font-semibold mb-4">More Actions</h6>
                            <ul class="links-list">
                                <li>
                                    <a><i class="pi pi-box"></i>Manage your modules</a>
                                </li>

                                <li>
                                    <a><i class="pi pi-bars"></i>Manage Menus</a>
                                </li>

                                <li>
                                    <a><i class="pi pi-microsoft"></i>Manage Blocks</a>
                                </li>

                                <li>
                                    <a><i class="pi pi-file"></i>Learn more about CMS</a>
                                </li>
                            </ul>
                        </div>

                        <Divider></Divider>

                        <template v-if="store && store.dashboard_items && store.dashboard_items.success"
                                  v-for="module in store.dashboard_items.success"
                        >
                            <div class="col-12" v-if="module.card">
                                <h5 class="text-lg font-semibold mb-4">{{ module.card.title }}</h5>

                                <div class="grid m-0">
                                    <template v-if="(key+1)%4 !== 0"
                                              v-for="(item,key) in module.card.list"
                                    >
                                        <div class="col">
                                            <span class="p-3 border-circle bg-blue-50">
                                                <i class="text-blue-400 pi" :class="item.icon"></i>
                                            </span>

                                            <p class="text-sm font-semibold mt-3">{{ item.label }}</p>
                                            <h6 class="text-xl font-semibold my-1">{{ item.count }}</h6>
                                            <a href="" @click="store.goToLink(item.link)"
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
            <Button label="Check Updates"
                    icon="pi pi-refresh"
                    class="p-button-sm p-button-outlined mr-2 mb-3"
            />

            <Button label="Getting Started"
                    icon="pi pi-play"
                    class="p-button-sm p-button-outlined mb-3"
            />

            <Accordion :multiple="true" :activeIndex="store.active_index">
                <AccordionTab header="Jobs">
                    <p class="text-sm">
                        Tasks that is kept in the queue to be performed one after another. Queues allow you to defer the processing of a time consuming task, such as sending an e-mail, until a later time which drastically speeds up web requests to your application.
                    </p>

                    <Divider></Divider>

                    <div class="flex justify-content-evenly align-items-center align-items-center">
                        <a href="" class="text-center">
                            <i class="pi pi-envelope mr-2"></i>
                            4 Pending
                        </a>

                        <Divider layout="vertical"></Divider>

                        <a href="" class="text-center">
                            <i class="pi pi-ban mr-2 text-red-500"></i>
                            0 Failed
                        </a>
                    </div>
                </AccordionTab>

                <AccordionTab header="Laravel logs (1)">
                    <div class="flex justify-content-between">
                        <p class="text-sm text-red-500">
                            laravel-2022-10-12.log
                        </p>
                        <a href="" class="text-sm">View</a>
                    </div>
                </AccordionTab>
            </Accordion>
        </div>
    </div>

</template>


