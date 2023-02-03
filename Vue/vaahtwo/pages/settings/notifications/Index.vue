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
    await store.getAssets();

});
</script>
<template>
    <Card class="notification-settings">
        <template #header>
            <div class="flex justify-content-between align-items-center">
                <h4 class="font-semibold text-lg">Notification</h4>
                <Button icon="pi pi-plus" label="Add" class="p-button-sm"
                        @click="store.addNewNotification"
                        data-testid="setting-notification_add_new"/>
            </div>
            <div class="col-12 mt-3" v-if="store.show_new_item_form">
                <Message severity="error" :closable="false">
                    These are notifications needs to be send manually.
                </Message>
                <div class="p-inputgroup">
                    <inputText data-testid="setting-notification_add_new_value"
                               v-model="store.new_item.name"
                               placeholder="Enter new notification name"
                              :autoResize="true" class="w-full" />
                    <Button icon="pi pi-save"
                            label="save"
                            @click="store.create"
                            data-testid="setting-notification_save_new"
                            class="has-max-height"/>
                </div>
            </div>
        </template>
        <template #content>
            <div class="grid" v-if="!store.active_notification">
                <div class="col">
                    <DataTable :value="store.notifications" stripedRows responsiveLayout="scroll" class="p-datatable-sm" showGridlines>
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
                                        class="p-button-rounded p-button-sm"></Button>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
            <div class="grid" v-else>
                <div class="col-12 mb-3">
                    <div class="flex align-items-center justify-content-between">
                        <h4 class="font-semibold text-xl">{{store.active_notification.name}}</h4>
                        <Button class="p-button-outlined p-button-sm"
                                label="Go back"
                                icon="pi pi-arrow-left"
                                icon-class="text-xs"
                                data-testid="setting-notification_back"
                                @click="store.hideNotificationSettings"></Button>
                    </div>
                </div>
                <div class="col-3 pr-3">
                    <h5 class="text-lg font-semibold mb-4">Variables</h5>
                    <div class="p-inputgroup mb-3">
                        <AutoComplete placeholder="Search"
                                      :suggestions="store.searched_notification_variables"
                                      @complete="store.searchNotificationVarialbles($event)"
                                      optionLabel="name"
                                      optionValue="id"
                        ></AutoComplete>
                    </div>
                    <div class="notification-variables pt-2 pr-1">
                        <div class="p-inputgroup mb-3" v-for="item in store.notification_variables">
                            <InputText :model-value="item.name" readonly></InputText>
                            <Button icon="pi pi-copy"
                                    :data-testid="'setting-notification_'+item.name+'_copy'"
                                    @click="store.getCopy(item.name)"></Button>
                            <Button icon="pi pi-question-circle"
                                    v-tooltip.top="item.details"
                                    class="p-button-secondary"></Button>
                        </div>
                    </div>
                </div>
                <div class="col-9 pl-3 p-fluid">
                    <h5 class="text-lg font-semibold mb-4">Notification Options</h5>
                    <div class="grid justify-content-between">
                        <div class="col-5">
                            <h5 class="text-sm font-semibold mb-2">Deliver via</h5>
                            <div class="flex justify-content-between">
                                <span>
                                    <h5 class="font-semibold text-xs mb-1">Mail</h5>
                                    <InputSwitch v-model="store.active_notification.via_mail"
                                                 data-testid="setting-notification_mail"
                                                 class="is-small"/>
                                </span>
                                <span>
                                    <h5 class="font-semibold text-xs mb-1">SMS</h5>
                                    <InputSwitch v-model="store.active_notification.via_sms"
                                                 data-testid="setting-notification_sms"
                                                 class="is-small"/>
                                </span>
                                <span>
                                    <h5 class="font-semibold text-xs mb-1">Push</h5>
                                    <InputSwitch v-model="store.active_notification.via_push"
                                                 data-testid="setting-notification_push"
                                                 class="is-small"/>
                                </span>
                                <span>
                                    <h5 class="font-semibold text-xs mb-1">Backend</h5>
                                    <InputSwitch v-model="store.active_notification.via_backend"
                                                 data-testid="setting-notification_backend"
                                                 class="is-small"/>
                                </span>
                                <span>
                                    <h5 class="font-semibold text-xs mb-1">Frontend</h5>
                                    <InputSwitch v-model="store.active_notification.via_frontend"
                                                 data-testid="setting-notification_frontend"
                                                 class="is-small"/>
                                </span>
                            </div>
                        </div>
                        <div class="col-6 justify-content-end flex">
                            <span class="text-right">
                                <h5 class="font-semibold text-xs mb-1">Error notifications</h5>
                                <InputSwitch v-model="store.active_notification.is_error"
                                             data-testid="setting-notification_error"
                                             class="is-small"/>
                            </span>
                        </div>
                        <div class="col-12">
                            <TabView ref="tabview1">
                                <TabPanel v-if="store.active_notification.via_mail" header="Mail" content-class="p-0">
                                    <div v-if="store.active_notification.contents" v-for="line in store.active_notification.contents.mail">
                                        <div v-if="line.key == 'subject'">
                                            <h5 class="p-1 text-xs mb-1 mt-3">Subject</h5>
                                            <div class="p-inputgroup">
                                                <InputText placeholder="Enter Subject"
                                                           data-testid="setting-notification_subject"
                                                           v-model="line.value"></InputText>
                                            </div>
                                        </div>
                                        <div v-if="line.key == 'from'">
                                            <h5 class="p-1 text-xs mb-1 mt-3">From</h5>
                                            <div class="p-inputgroup">
                                                <InputText placeholder="Enter From"
                                                           v-model="line.meta.name"
                                                           data-testid="setting-notification_from"></InputText>
                                            </div>
                                            <h5 class="p-1 text-xs mb-1 mt-3">From Email</h5>
                                            <div class="p-inputgroup">
                                                <InputText placeholder="Enter From"
                                                           v-model="line.value"
                                                           data-testid="setting-notification_from_email"></InputText>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="store.active_notification.contents">
                                        <div v-if="store.active_notification.contents.mail
                                             && store.active_notification.contents.mail.length > 0"
                                             v-for="line in store.active_notification.contents.mail">
                                            <div  v-if="line.key == 'line' || line.key == 'greetings'">
                                                <h5 class="p-1 text-xs mb-1 mt-3">{{vaah().toLabel(line.key)}}</h5>
                                                <div class="p-inputgroup">
                                                    <InputText v-model="line.value"
                                                               v-if="line.key == 'line'"
                                                               :data-testid="'setting-notification_'+line.key"
                                                               placeholder="Content with variables"></InputText>

                                                    <Textarea v-else
                                                              v-model="line.value"
                                                              :autoResize="true"
                                                              :data-testid="'setting-notification_'+line.key"
                                                              class="w-full"
                                                              placeholder="Content with variables"/>
                                                    <Button icon="pi pi-trash"
                                                            :data-testid="'setting-notification_remove_'+line.key"
                                                            @click="store.removeContent(line,'mail')"
                                                            class="has-max-height"/>
                                                </div>
                                            </div>
                                            <div  v-if="line.key == 'action'">
                                                <h5 class="p-1 text-xs mb-1 mt-3">Action</h5>
                                                <div class="p-inputgroup">
                                                    <InputText v-model="line.value"
                                                               data-testid="setting-notification_action_value"
                                                               placeholder="Enter action label"></InputText>
                                                    <Dropdown v-model="line.meta.action"
                                                              :options="store.notification_actions"
                                                              optionLabel="name"
                                                              optionValue="name"
                                                              data-testid="setting-notification_action_option"
                                                              placeholder="Choose an action"></Dropdown>
                                                    <Button icon="pi pi-trash"
                                                            data-testid="setting-notification_remove_action"
                                                            @click="store.removeContent(line,'mail')"
                                                            class="has-max-height"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex mt-5">
                                            <Button icon=""
                                                    label="Add Subject"
                                                    class="w-auto mr-2 p-button-sm"
                                                    @click="store.addSubject"
                                                    data-testid="setting-notification_add_subject"
                                                    :disabled="store.is_add_subject_disabled"></Button>
                                            <Button icon=""
                                                    label="Add From"
                                                    class="w-auto mr-2 p-button-sm"
                                                    @click="store.addFrom"
                                                    data-testid="setting-notification_add_from"
                                                    :disabled="store.is_add_from_disabled"></Button>
                                            <Button icon=""
                                                    label="Add Greetings"
                                                    @click="store.addToMail('greetings')"
                                                    data-testid="setting-notification_add_greetings"
                                                    class="w-auto mr-2 p-button-sm"></Button>
                                            <Button icon=""
                                                    label="Add Line"
                                                    @click="store.addToMail('line')"
                                                    data-testid="setting-notification_add_line"
                                                    class="w-auto mr-2 p-button-sm"></Button>
                                            <Button icon=""
                                                    label="Add Action"
                                                    @click="store.addAction"
                                                    data-testid="setting-notification_add_action"
                                                    class="w-auto p-button-sm"></Button>
                                        </div>
                                </TabPanel>
                                <TabPanel v-if="store.active_notification.via_sms" header="SMS">
                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.sms
                                                && store.active_notification.contents.sms.length > 0"
                                         v-for="line in store.active_notification.contents.sms">
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <h5 class="p-1 text-xs mb-1">Message</h5>
                                            <div class="p-inputgroup">
                                            <Textarea v-model="line.value"
                                                      data-testid="setting-notification_sms_message"
                                                      :autoResize="true" class="w-full" />
                                                <Button icon="pi pi-copy"
                                                        @click="store.getCopy"
                                                        data-testid="setting-notification_sms_message_copy"
                                                        class="has-max-height"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <Button label="Add Content"
                                                data-testid="setting-notification_add_sms"
                                                @click="store.addSmsContent"
                                                class="w-auto m-3 p-button-sm"></Button>
                                    </div>
                                </TabPanel>
                                <TabPanel v-if="store.active_notification.via_push" header="Push">
                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.push
                                                && store.active_notification.contents.push.length > 0"
                                         v-for="line in store.active_notification.contents.push">
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <h5 class="p-1 text-xs mb-1">Message</h5>
                                            <div class="p-inputgroup">
                                            <Textarea v-model="line.value"
                                                      data-testid="setting-notification_push_message"
                                                      :autoResize="true" class="w-full" />
                                                <Button icon="pi pi-copy"
                                                        @click="store.getCopy"
                                                        data-testid="setting-notification_push_message_copy"
                                                        class="has-max-height"/>
                                            </div>
                                        </div>
                                        <div class="col-12 px-0" v-if="line.key == 'action'">
                                            <h5 class="p-1 text-xs mb-1">Action</h5>
                                            <div class="p-inputgroup">
                                                <InputText placeholder="Enter action label"
                                                           v-model="line.value"
                                                           data-testid="setting-notification_push_message"></InputText>
                                                <Dropdown placeholder="Choose an action"
                                                          v-model="line.meta.action"
                                                          :options="store.notification_actions"
                                                          optionLabel="name"
                                                          optionValue="name"
                                                          data-testid="setting-notification_push_message_copy"></Dropdown>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <Button label="Add Content"
                                                data-testid="setting-notification_add_push"
                                                @click="store.addPushContent"
                                                class="w-auto m-3 p-button-sm"></Button>
                                    </div>
                                </TabPanel>
                                <TabPanel v-if="store.active_notification.via_backend" header="Backend">
                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.backend
                                                && store.active_notification.contents.backend.length > 0"
                                         v-for="line in store.active_notification.contents.backend">
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <h5 class="p-1 text-xs mb-1">Message</h5>
                                            <div class="p-inputgroup">
                                            <Textarea v-model="line.value"
                                                      data-testid="setting-notification_backend_message"
                                                      :autoResize="true" class="w-full" />
                                                <Button icon="pi pi-copy"
                                                        @click="store.getCopy"
                                                        data-testid="setting-notification_backend_message_copy"
                                                        class="has-max-height"/>
                                            </div>
                                        </div>
                                        <div class="col-12 px-0" v-if="line.key == 'action'">
                                            <h5 class="p-1 text-xs mb-1">Action</h5>
                                            <div class="p-inputgroup">
                                                <InputText placeholder="Enter action label"
                                                           v-model="line.value"
                                                           data-testid="setting-notification_backend_message"></InputText>
                                                <Dropdown placeholder="Choose an action"
                                                          v-model="line.meta.action"
                                                          :options="store.notification_actions"
                                                          optionLabel="name"
                                                          optionValue="name"
                                                          data-testid="setting-notification_backend_message_copy"></Dropdown>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <Button label="Add Content"
                                                data-testid="setting-notification_add_backend"
                                                @click="store.addBackendContent"
                                                class="w-auto m-3 p-button-sm"></Button>
                                    </div>
                                </TabPanel>
                                <TabPanel v-if="store.active_notification.via_frontend" header="Frontend">
                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.frontend
                                                && store.active_notification.contents.frontend.length > 0"
                                         v-for="line in store.active_notification.contents.frontend">
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <h5 class="p-1 text-xs mb-1">Message</h5>
                                            <div class="p-inputgroup">
                                            <Textarea v-model="line.value"
                                                      data-testid="setting-notification_frontend_message"
                                                      :autoResize="true" class="w-full" />
                                                <Button icon="pi pi-copy"
                                                        @click="store.getCopy"
                                                        data-testid="setting-notification_frontend_message_copy"
                                                        class="has-max-height"/>
                                            </div>
                                        </div>
                                        <div class="col-12 px-0" v-if="line.key == 'action'">
                                            <h5 class="p-1 text-xs mb-1">Action</h5>
                                            <div class="p-inputgroup">
                                                <InputText placeholder="Enter action label"
                                                           v-model="line.value"
                                                           data-testid="setting-notification_frontend_message"></InputText>
                                                <Dropdown placeholder="Choose an action"
                                                          v-model="line.meta.action"
                                                          :options="store.notification_actions"
                                                          optionLabel="name"
                                                          optionValue="name"
                                                          data-testid="setting-notification_frontendv_message_copy"></Dropdown>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <Button label="Add Content"
                                                data-testid="setting-notification_add_frontend"
                                                @click="store.addFrontendContent"
                                                class="w-auto m-3 p-button-sm"></Button>
                                    </div>
                                </TabPanel>
                            </TabView>
                            <div class="col-12 mt-4">
                                <div class="col-12 col-2">
                                    <Button label="Save" icon="pi pi-save"
                                            data-testid="setting-notification_store"
                                            @click="store.storeNotification"
                                            class="w-auto mr-3 p-button-sm"></Button>
                                    <Button label="Test"
                                            data-testid="setting-notification_test"
                                            @click="store.is_testing=true"
                                            icon="pi pi-reply"
                                            class="w-auto p-button-sm"></Button>
                                </div>
                                <div class="col-12 col-6">
                                    <div class="p-inputgroup" v-if="store.is_testing">
                                        <AutoComplete v-model="store.send_to"
                                                      :suggestions="store.user_list"
                                                      @complete="store.searchUser($event)"
                                                      optionLabel="name"
                                                      optionValue="email"
                                                      placeholde="Search..."/>
                                        <Button label="Send"
                                                data-testid="setting-notification_test_send"
                                                @click="store.sendNotification"
                                                icon="pi pi-reply"
                                                class="w-auto p-button-sm"></Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>

<style lang="scss">
.notification-settings{
    .p-tabview .p-tabview-panels{
        padding: 0;
    }
    .notification-variables{
        max-height: 50vh;
        overflow-y: auto;
        &::-webkit-scrollbar {
            width: 5px;
        }
        &::-webkit-scrollbar-track {
            width:5px;
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }
        &::-webkit-scrollbar-thumb {
            background-color: darkgrey;
            outline: 1px solid slategrey;
            width: 5px;
        }
    }
}
</style>
