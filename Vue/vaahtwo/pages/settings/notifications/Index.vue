<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';
import draggable from 'vuedraggable';
import { vaah } from '../../../vaahvue/pinia/vaah'
import {useNotificationStore} from "../../../stores/settings/store-notification";

const store = useNotificationStore();
const route = useRoute();

import { useConfirm } from "primevue/useconfirm";

const confirm = useConfirm();
onMounted(async () => {

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.setPageTitle();
    await store.getAssets();

});
</script>
<template>
    <Panel class="is-small">
        <template class="p-1" #header>
            <div class="flex flex-row">
                <div>
                    <b class="mr-1">Notifications</b>
                </div>
            </div>
        </template>

        <template #icons>
            <div class="buttons">
                <Button icon="pi pi-plus"
                        label="Add"
                        class="p-button-sm"
                        @click="store.addNewNotification"
                        data-testid="setting-notification_add_new"
                />
            </div>

        </template>
        <div class="grid">
            <div class="col-12" v-if="store && store.assets && store.assets.notifications">
                <div class="p-inputgroup">
                    <Dropdown v-model="store.notification"
                              :options="store.assets.notifications"
                              optionLabel="name"
                              optionValue="id"
                              :filter="true"
                              placeholder="Search"
                              data-testid="notification-search"
                              class="w-full"
                              @change="store.callShowNotificationSettings()"
                              inputClass="p-inputtext-sm"
                    />

                    <Button class="p-button-sm"
                            label="Reset"
                            @click="store.clearNotificationSearch"
                            data-testid="notification-search_reset"
                    />
                </div>
            </div>

            <div class="col-12 mt-3" v-if="store.show_new_item_form">
                <Message severity="error" :closable="false">
                    These are notifications needs to be send manually.
                </Message>

                <div class="p-inputgroup">
                    <inputText data-testid="setting-notification_add_new_value"
                               v-model="store.new_item.name"
                               placeholder="Enter new notification name"
                               :autoResize="true"
                               class="w-full"
                               inputClass="p-inputtext-sm"
                    />

                    <Button icon="pi pi-save"
                            label="save"
                            @click="store.create"
                            data-testid="setting-notification_save_new"
                            class="has-max-height p-button-sm"
                    />
                </div>
            </div>
        </div>


        <div class="grid" v-if="!store.active_notification">
            <div class="col">
                <DataTable :value="store.notifications" stripedRows responsiveLayout="scroll" class="p-datatable-sm">
                    <Column header="Notification Title">
                        <template #body="slotProps">
                            <p>{{slotProps.data.name}}</p>
                        </template>
                    </Column>
                    <Column header="Edit">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil"
                                    :data-testid="'setting-notification_'+slotProps.data.name"
                                    @click="store.showNotificationSettings(slotProps.data)"
                                    class=" p-button-sm"></Button>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
        <div class="grid" v-else>
            <div class="col-12 mt-2 mb-0">
                <div class="level">
                    <div class="flex align-items-center">

                        <Button class="p-button-outlined p-button-sm mr-2"
                                label="Go back"
                                icon="pi pi-arrow-left"
                                icon-class="text-xs"
                                data-testid="setting-notification_back"
                                @click="store.hideNotificationSettings"
                        />
                        <h4>{{store.active_notification.name}}</h4>


                    </div>
                    <div class="level-right">
                        <Button v-if="store.assets && store.assets.help_urls"
                                icon="pi pi-question-circle"
                                @click="store.getNotificationDcoument(store.assets.help_urls.send_notification)"
                                data-testid="setting-notification_tooltip"
                                class="p-button-sm mr-2"
                        />
                        <Button icon="pi pi-copy"
                                :data-testid="'setting-notification_'+store.active_notification.slug+'_copy'"
                                @click="store.getCopy(store.active_notification.slug)"
                                class="p-button-sm "
                        />

                    </div>


                </div>
            </div>
            <div class="col-3">

                <Panel class="is-small">
                    <template class="p-1" #header>
                        <div class="flex flex-row">
                            <div>
                                <b class="mr-1">Variables</b>
                            </div>
                        </div>
                    </template>
                    <div class="mt-2 mb-2">
                        <AutoComplete placeholder="Search"
                                      :suggestions="store.searched_notification_variables"
                                      @complete="store.searchNotificationVarialbles($event)"
                                      optionLabel="name"
                                      data-testid="setting-notification_search"
                                      optionValue="id"
                                      class="p-inputtext-sm w-full"
                        />
                    </div>
                    <div class="notification-variables">
                        <div class="p-inputgroup mb-2" v-for="item in store.notification_variables">
                            <InputText :model-value="item.name"
                                       data-testis="setting-notification_search"
                                       readonly
                                       class="p-inputtext-sm"
                            />

                            <Button icon="pi pi-copy"
                                    :data-testid="'setting-notification_'+item.name+'_copy'"
                                    @click="store.getCopy(item.name)"
                                    class="p-button-sm"
                            />

                            <Button icon="pi pi-question-circle"
                                    data-testid="setting-notification_tooltip"
                                    v-tooltip.top="item.details"
                                    class="p-button-secondary p-button-sm"
                            />
                        </div>
                    </div>
                </Panel>


            </div>

            <div class="col-9 pl-3 p-fluid">
                <Panel class="is-small">
                    <template class="p-1" #header>
                        <div class="flex flex-row">
                            <div>
                                <b class="mr-1">Notification Options</b>
                            </div>
                        </div>
                    </template>
                    <div class="grid justify-content-between">
                        <div class="col-5">
                            <h5 class="text-sm font-semibold mb-2">Deliver via</h5>

                            <div class="flex justify-content-between">
                                <span>
                                    <h5 class="font-semibold text-xs mb-1">Mail</h5>

                                    <InputSwitch v-model="store.active_notification.via_mail"
                                                 data-testid="setting-notification_mail"
                                                 class="is-small"
                                    />
                                </span>

                                <span>
                                    <h5 class="font-semibold text-xs mb-1">SMS</h5>

                                    <InputSwitch v-model="store.active_notification.via_sms"
                                                 data-testid="setting-notification_sms"
                                                 class="is-small"
                                    />
                                </span>

                                <span>
                                    <h5 class="font-semibold text-xs mb-1">Push</h5>

                                    <InputSwitch v-model="store.active_notification.via_push"
                                                 data-testid="setting-notification_push"
                                                 class="is-small"
                                    />
                                </span>

                                <span>
                                    <h5 class="font-semibold text-xs mb-1">Backend</h5>

                                    <InputSwitch v-model="store.active_notification.via_backend"
                                                 data-testid="setting-notification_backend"
                                                 class="is-small"
                                    />
                                </span>

                                <span>
                                    <h5 class="font-semibold text-xs mb-1">Frontend</h5>
                                    <InputSwitch v-model="store.active_notification.via_frontend"
                                                 data-testid="setting-notification_frontend"
                                                 class="is-small"
                                    />
                                </span>
                            </div>
                        </div>
                        <div class="col-6 justify-content-end flex">
                            <span class="text-right">
                                <h5 class="font-semibold text-xs mb-1">Error notifications</h5>
                                <InputSwitch v-model="store.active_notification.is_error"
                                             data-testid="setting-notification_error"
                                             class="is-small"
                                />
                            </span>
                        </div>

                        <div class="col-12">
                            <TabView ref="tabview1" class="is-small tab-panel-has-no-padding">
                                <TabPanel v-if="store.active_notification.via_mail" header="Mail" >
                                    <div v-if="store.active_notification.contents" v-for="line in store.active_notification.contents.mail">
                                        <div v-if="line.key == 'subject'" >
                                            <div class="mb-3">
                                                <h5 class="px-1 text-xs mb-1">Subject</h5>
                                                <InputText placeholder="Enter Subject"
                                                           data-testid="setting-notification_subject"
                                                           v-model="line.value"
                                                           class="p-inputtext-sm"
                                                />
                                            </div>

                                        </div>
                                        <div v-if="line.key == 'from'">
                                            <div class="mb-3">
                                                <h5 class="px-1 text-xs mb-1">From</h5>

                                                <InputText placeholder="Enter From"
                                                           v-model="line.meta.name"
                                                           data-testid="setting-notification_from"
                                                           class="p-inputtext-sm"
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <h5 class="px-1 text-xs mb-1">From Email</h5>
                                                <InputText placeholder="Enter From"
                                                           v-model="line.value"
                                                           data-testid="setting-notification_from_email"
                                                           class="p-inputtext-sm"
                                                />
                                                </div>


                                        </div>
                                    </div>

                                    <div v-if="store.active_notification.contents">
                                        <div v-if="store.active_notification.contents.mail
                                             && store.active_notification.contents.mail.length > 0"
                                             v-for="line in store.active_notification.contents.mail">
                                            <div  v-if="line.key == 'line' || line.key == 'greetings'">
                                                <div class="mb-3">
                                                <h5 class="px-1 text-xs mb-1">{{vaah().toLabel(line.key)}}</h5>
                                                <div class="p-inputgroup">
                                                    <Textarea v-model="line.value"
                                                              v-if="line.key == 'line'"
                                                              :data-testid="'setting-notification_'+line.key"
                                                              placeholder="Content with variables"
                                                              class="p-inputtext-sm"
                                                    />

                                                    <Textarea v-else
                                                              v-model="line.value"
                                                              :auto-resize="true"
                                                              :data-testid="'setting-notification_'+line.key"
                                                              class="w-full"
                                                              placeholder="Content with variables"
                                                    />

                                                    <Button icon="pi pi-trash"
                                                            :data-testid="'setting-notification_remove_'+line.key"
                                                            @click="store.removeContent(line,'mail')"
                                                    />
                                                </div>
                                                </div>
                                            </div>

                                            <div  v-if="line.key == 'action'" class="mb-3">
                                                <h5 class="px-1 text-xs mb-1">Action</h5>
                                                <div class="p-inputgroup">
                                                    <InputText v-model="line.value"
                                                               data-testid="setting-notification_action_value"
                                                               placeholder="Enter action label"
                                                               class="p-inputtext-sm"
                                                    />

                                                    <Dropdown v-model="line.meta.action"
                                                              :options="store.notification_actions"
                                                              optionLabel="name"
                                                              optionValue="name"
                                                              data-testid="setting-notification_action_option"
                                                              placeholder="Choose an action"
                                                              class="p-inputtext-sm is-small"

                                                    />

                                                    <Button icon="pi pi-trash"
                                                            data-testid="setting-notification_remove_action"
                                                            @click="store.removeContent(line,'mail')"
                                                            class="has-max-height p-button-sm"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-content-end">
                                        <Button label="Add Subject"
                                                class="w-auto mr-2 p-button-sm"
                                                @click="store.addSubject"
                                                data-testid="setting-notification_add_subject"
                                                :disabled="store.is_add_subject_disabled"
                                        />

                                        <Button label="Add From"
                                                class="w-auto mr-2 p-button-sm"
                                                @click="store.addFrom"
                                                data-testid="setting-notification_add_from"
                                                :disabled="store.is_add_from_disabled"
                                        />

                                        <Button label="Add Greetings"
                                                @click="store.addToMail('greetings')"
                                                data-testid="setting-notification_add_greetings"
                                                class="w-auto mr-2 p-button-sm"
                                        />

                                        <Button label="Add Line"
                                                @click="store.addToMail('line')"
                                                data-testid="setting-notification_add_line"
                                                class="w-auto mr-2 p-button-sm"
                                        />

                                        <Button label="Add Action"
                                                @click="store.addAction"
                                                data-testid="setting-notification_add_action"
                                                class="w-auto p-button-sm"
                                        />
                                    </div>
                                </TabPanel>

                                <TabPanel v-if="store.active_notification.via_sms" header="SMS">
                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.sms
                                                && store.active_notification.contents.sms.length > 0"
                                         v-for="line in store.active_notification.contents.sms"
                                    >
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <h5 class="p-1 text-xs mb-1">Message</h5>

                                            <div class="p-inputgroup">
                                                <Textarea v-model="line.value"
                                                          data-testid="setting-notification_sms_message"
                                                          :autoResize="true" class="w-full"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <div v-else>

                                        <Message
                                                 severity="primary" :closable="false" class="text-center pt-3">
                                            <p><i class="pi pi-sync"></i></p>
                                            <p>It looks like you haven't added any content to this section yet.</p>

                                            <Button label="Add Content"
                                                    data-testid="setting-notification_add_sms"
                                                    @click="store.addSmsContent"
                                                    class="w-auto my-3 p-button-sm"
                                            />
                                        </Message>

                                    </div>
                                </TabPanel>

                                <TabPanel v-if="store.active_notification.via_push" header="Push">
                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.push
                                                && store.active_notification.contents.push.length > 0"
                                         v-for="line in store.active_notification.contents.push"
                                    >
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <h5 class="p-1 text-xs mb-1">Message</h5>

                                            <div class="p-inputgroup">
                                                <Textarea v-model="line.value"
                                                          data-testid="setting-notification_push_message"
                                                          :autoResize="true" class="w-full"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-12 px-0" v-if="line.key == 'action'">
                                            <h5 class="p-1 text-xs mb-1">Action</h5>

                                            <div class="p-inputgroup">
                                                <InputText placeholder="Enter action label"
                                                           v-model="line.value"
                                                           data-testid="setting-notification_push_message"
                                                           inputClass="p-inputtext-sm"
                                                />

                                                <Dropdown placeholder="Choose an action"
                                                          v-model="line.meta.action"
                                                          :options="store.notification_actions"
                                                          optionLabel="name"
                                                          optionValue="name"
                                                          data-testid="setting-notification_push_message_copy"
                                                          inputClass="p-inputtext-sm"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <div v-else>
                                        <Message
                                            severity="primary" :closable="false" class="text-center pt-3">
                                            <p><i class="pi pi-sync"></i></p>
                                            <p>It looks like you haven't added any content to this section yet.</p>
                                            <Button label="Add Content"
                                                    data-testid="setting-notification_add_push"
                                                    @click="store.addPushContent"
                                                    class="w-auto my-3 p-button-sm"
                                            />

                                        </Message>

                                    </div>
                                </TabPanel>

                                <TabPanel v-if="store.active_notification.via_backend" header="Backend">
                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.backend
                                                && store.active_notification.contents.backend.length > 0"
                                         v-for="line in store.active_notification.contents.backend"
                                    >
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <h5 class="p-1 text-xs mb-1">Message</h5>

                                            <div class="p-inputgroup">
                                                <Textarea v-model="line.value"
                                                          data-testid="setting-notification_backend_message"
                                                          :autoResize="true" class="w-full"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-12 px-0" v-if="line.key == 'action'">
                                            <h5 class="p-1 text-xs mb-1">Action</h5>
                                            <div class="p-inputgroup">
                                                <InputText placeholder="Enter action label"
                                                           v-model="line.value"
                                                           data-testid="setting-notification_backend_message"
                                                           inputClass="p-inputtext-sm"
                                                />
                                                <Dropdown placeholder="Choose an action"
                                                          v-model="line.meta.action"
                                                          :options="store.notification_actions"
                                                          optionLabel="name"
                                                          optionValue="name"
                                                          data-testid="setting-notification_backend_message_copy"
                                                          inputClass="p-inputtext-sm"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <div v-else>
                                        <Message
                                            severity="primary" :closable="false" class="text-center pt-3">
                                            <p><i class="pi pi-sync"></i></p>
                                            <p>It looks like you haven't added any content to this section yet.</p>

                                            <Button label="Add Content"
                                                    data-testid="setting-notification_add_backend"
                                                    @click="store.addBackendContent"
                                                    class="w-auto my-3 p-button-sm"
                                            />

                                        </Message>

                                    </div>
                                </TabPanel>

                                <TabPanel v-if="store.active_notification.via_frontend" header="Frontend">
                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.frontend
                                                && store.active_notification.contents.frontend.length > 0"
                                         v-for="line in store.active_notification.contents.frontend"
                                    >
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <h5 class="p-1 text-xs mb-1">Message</h5>

                                            <div class="p-inputgroup">
                                                <Textarea v-model="line.value"
                                                          data-testid="setting-notification_frontend_message"
                                                          :autoResize="true" class="w-full"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-12 px-0" v-if="line.key == 'action'">
                                            <h5 class="p-1 text-xs mb-1">Action</h5>

                                            <div class="p-inputgroup">
                                                <InputText placeholder="Enter action label"
                                                           v-model="line.value"
                                                           data-testid="setting-notification_frontend_message"
                                                           inputClass="p-inputtext-sm"
                                                />
                                                <Dropdown placeholder="Choose an action"
                                                          v-model="line.meta.action"
                                                          :options="store.notification_actions"
                                                          optionLabel="name"
                                                          optionValue="name"
                                                          data-testid="setting-notification_frontendv_message_copy"
                                                          inputClass="p-inputtext-sm"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <div v-else>
                                        <Message
                                            severity="primary" :closable="false" class="text-center pt-3">
                                            <p><i class="pi pi-sync"></i></p>
                                            <p>It looks like you haven't added any content to this section yet.</p>

                                            <Button label="Add Content"
                                                    data-testid="setting-notification_add_frontend"
                                                    @click="store.addFrontendContent"
                                                    class="w-auto my-3 p-button-sm"
                                            />
                                        </Message>

                                    </div>
                                </TabPanel>
                            </TabView>
                            <Divider class="mb-3 mt-1"/>
                            <div class="flex justify-content-end">
                                <Button label="Save" icon="pi pi-save"
                                        data-testid="setting-notification_store"
                                        @click="store.storeNotification"
                                        class="w-auto mr-3 p-button-sm"
                                />

                                <Button label="Test"
                                        data-testid="setting-notification_test"
                                        @click="store.is_testing=true"
                                        icon="pi pi-reply"
                                        class="w-auto p-button-sm"
                                />
                            </div>

                            <div class="p-inputgroup mt-3" v-if="store.is_testing">
                                <AutoComplete v-model="store.send_to"
                                              :suggestions="store.user_list"
                                              @complete="store.searchUser($event)"
                                              optionLabel="name"
                                              optionValue="email"
                                              placeholde="Search..."
                                              inputClass="p-inputtext-sm"
                                />

                                <Button label="Send"
                                        data-testid="setting-notification_test_send"
                                        @click="store.sendNotification"
                                        icon="pi pi-reply"
                                        class="w-auto p-button-sm"
                                />
                            </div>
                        </div>
                    </div>
                </Panel>

            </div>
        </div>
    </Panel>
</template>


