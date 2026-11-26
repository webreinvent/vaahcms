<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';
import draggable from 'vuedraggable';
import { vaah } from '../../../../vaahvue/pinia/vaah'
import {useNotificationStore} from "../../../../stores/settings/store-notification";
const root = useRootStore();
const store = useNotificationStore();
const route = useRoute();

import { useConfirm } from "openvue/useconfirm";
import {useRootStore} from "../../../../stores/root";

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

        <div >

        </div>



        <div v-if="!store.active_notification">
            <div  v-if="store.list && store.assets && store.list.data ">
                <DataTable size="small" rowHover :value="store.list.data" stripedRows dataKey="id" scrollable v-model:selection="store.action.items" class="">

                    <Column selectionMode="multiple"

                            headerStyle="width: 3em"
                    />
                    <Column  :header="store.assets.language_strings.column_notification_title">
                        <template #body="slotProps">
                            <Badge v-if="slotProps.data.deleted_at"
                                   value="Trashed"
                                   severity="danger"
                            />
                            <p>{{slotProps.data.name}}</p>
                        </template>
                    </Column>
                    <!-- UT-93 (M6-T4a Batch 18) — this column holds the edit,
                         delete and restore buttons, so it is an action column.
                         It was headed "Edit" (column_edit) while every other
                         list page heads the same column "Actions", and its
                         header was pushed to the opposite edge of the cell
                         from the buttons by a `text-right` class (the `pt`
                         override beside it never applied — the v4 section is
                         `columnheadercontent`, not `headercontent`). The
                         column now follows the canonical action column: the
                         header sits over the buttons. -->
                    <Column :header="store.getActionLabel()" field="actions"
                            style="width:150px;"
                            :style="{ width: store.getActionWidth() }"
                            v-if="root.assets
                          && root.assets.language_strings
                          && root.assets.language_strings.crud_actions">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" aria-label="Edit notification"
                                    :data-testid="'setting-notification_'+slotProps.data.name"
                                    v-if="!slotProps.data.deleted_at"
                                    @click="store.showNotificationSettings(slotProps.data)"
                                    class="p-button-tiny p-button-text" v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_edit"></Button>

                            <Button aria-label="Delete notification" class="p-button-tiny p-button-danger p-button-text"
                                    v-if="store.isViewLarge() && !slotProps.data.deleted_at"
                                    @click="store.itemAction('trash', slotProps.data)"
                                    v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_trash"
                                    icon="pi pi-trash"
                                    data-testid="setting-notification_data_trash"
                            ></Button>
                            <Button aria-label="Restore notification" class="p-button-tiny p-button-success p-button-text"
                                    v-if="store.isViewLarge() && slotProps.data.deleted_at"
                                    @click="store.itemAction('restore', slotProps.data)"
                                    v-tooltip.top="root.assets.language_strings.crud_actions.toolkit_text_restore"
                                    icon="pi pi-replay"
                                    data-testid="setting-notification-list_data_restore"
                            />
                        </template>
                    </Column>
                    <!-- M7-T3 (F26) — the v4 engine renders a blank cell
                         when the #empty slot is absent, so the slot says
                         what to do next (DESIGN-SYSTEM §8). Notification
                         templates ship with the application — the CTA
                         clears the active search. -->
                    <template #empty>
                        <div class="vaah-empty" data-testid="setting-notification-list_empty">
                            <i class="vaah-empty-icon pi pi-bell" aria-hidden="true"></i>
                            <p class="vaah-empty-copy">No notification templates match your search.</p>
                            <Button :label="root.assets.language_strings.crud_actions.reset_button" icon="pi pi-filter-slash" @click="store.resetQuery()" data-testid="setting-notification-list_empty_reset" />
                        </div>
                    </template>
                </DataTable>
                <Paginator v-model:rows="store.query.rows"
                           :first="(store.query.page-1)*store.query.rows"
                           :totalRecords="store.list.total"
                           @page="store.paginate($event)"
                           :rowsPerPageOptions="store.rows_per_page"
                           class="bg-white-alpha-0 pt-2" />
            </div>
        </div>

        <div class="grid" v-else-if="store.route.params.id && store.assets">
            <div class="col-12 mt-2 mb-0">
                <div class="level">
                    <div class="flex align-items-center">

                        <Button size="small" class="p-button-outlined mr-2" :label="store.assets.language_strings.go_back_button" icon="pi pi-arrow-left" data-testid="setting-notification_back" @click="store.hideNotificationSettings" />
                        <h2 class="vaah-type-title">{{store.active_notification.name}} </h2>


                    </div>
                    <div class="level-right">
                        <Button size="small" v-if="store.assets && store.assets.help_urls" icon="pi pi-question-circle" aria-label="Notification help" @click="store.getNotificationDcoument(store.assets.help_urls.send_notification)" data-testid="setting-notification_tooltip" class=" mr-2" />
                        <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" :data-testid="'setting-notification_'+store.active_notification.slug+'_copy'" @click="store.getCopy(store.active_notification.slug)" class=" " />

                    </div>


                </div>
            </div>
            <div class="col-3">

                <Panel class="vc-dense">
                    <template class="p-1" #header>
                        <div class="flex flex-row">
                            <div>
                                <h3 class="mr-1 vaah-type-section">{{ store.assets.language_strings.variables }}</h3>
                            </div>
                        </div>
                    </template>
                    <InputGroup class="mt-2 mb-2">
                        <AutoComplete aria-label="Search notification variables" size="small" :placeholder="store.assets.language_strings.variables_placeholder_search" :suggestions="store.searched_notification_variables" @complete="store.searchNotificationVarialbles($event)" optionLabel="name" data-testid="setting-notification_search" optionValue="id" class=" w-full" />
                    </InputGroup>
                    <div class="notification-variables">
                        <!-- UT-77 — the v3 → v4 migration dropped the
                             `v-for` that walked `store.notification_variables`,
                             so the panel rendered a single row reading
                             `item.name` of an undefined `item` and every
                             render of the notification form threw
                             "Cannot read properties of undefined (reading 'name')".
                             The loop is restored (it was in the v2 source). -->
                        <!-- UT-135 — the variables carry no `id` (the API
                             returns `name` + `details` only), so the row's
                             test id read "..._undefined" — five rows with
                             the same test id — and the read-only input had
                             no accessible name at all. The row is keyed and
                             named by its position and by the variable. -->
                        <InputGroup class="mb-2" v-for="(item, index) in store.notification_variables" :key="index">
                            <InputText size="small" :model-value="item.name" :aria-label="item.name" :data-testid="'setting-notification_variable_'+index" readonly class="" />

                            <Button size="small" icon="pi pi-copy" aria-label="Copy to clipboard" :data-testid="'setting-notification_'+item.name+'_copy'" @click="store.getCopy(item.name)" class="" />

                            <Button size="small" icon="pi pi-question-circle" aria-label="More information" :data-testid="'setting-notification_details_'+index" v-tooltip.top="item.details" class="p-button-secondary" />
                        </InputGroup>
                    </div>
                </Panel>


            </div>

            <Fluid class="col-9 pl-3">
                <Panel class="vc-dense">
                    <template class="p-1" #header>
                        <div class="flex flex-row">
                            <div>
                                <h3 class="mr-1 vaah-type-section">{{ store.assets.language_strings.notification_options }}</h3>
                            </div>
                        </div>
                    </template>
                    <div class="grid justify-content-between">
                        <div class="col-5">
                            <h3 class="vaah-type-subhead mb-2">{{ store.assets.language_strings.deliver_via }}</h3>

                            <div class="flex justify-content-between">
                                <span>
                                    <div class="vaah-type-caption mb-1" id="nf-notification-field-mail-1">{{ store.assets.language_strings.notification_field_mail }}</div>

                                    <ToggleSwitch aria-labelledby="nf-notification-field-mail-1" v-model="store.active_notification.via_mail"
                                                 data-testid="setting-notification_mail"
                                                 class="vc-dense"
                                    />
                                </span>

                                <span>
                                    <div class="vaah-type-caption mb-1" id="nf-sms-1">SMS</div>

                                    <ToggleSwitch aria-labelledby="nf-sms-1" v-model="store.active_notification.via_sms"
                                                 data-testid="setting-notification_sms"
                                                 class="vc-dense"
                                    />
                                </span>

                                <span>
                                    <div class="vaah-type-caption mb-1" id="nf-notification-field-push-1">{{ store.assets.language_strings.notification_field_push }}</div>

                                    <ToggleSwitch aria-labelledby="nf-notification-field-push-1" v-model="store.active_notification.via_push"
                                                 data-testid="setting-notification_push"
                                                 class="vc-dense"
                                    />
                                </span>

                                <span>
                                    <div class="vaah-type-caption mb-1" id="nf-backend-1">{{ store.assets.language_strings.backend }}</div>

                                    <ToggleSwitch aria-labelledby="nf-backend-1" v-model="store.active_notification.via_backend"
                                                 data-testid="setting-notification_backend"
                                                 class="vc-dense"
                                    />
                                </span>

                                <span>
                                    <div class="vaah-type-caption mb-1" id="nf-frontend-1">Frontend</div>
                                    <ToggleSwitch aria-labelledby="nf-frontend-1" v-model="store.active_notification.via_frontend"
                                                 data-testid="setting-notification_frontend"
                                                 class="vc-dense"
                                    />
                                </span>
                            </div>
                        </div>
                        <div class="col-6 justify-content-end flex">
                            <span class="text-right">
                                <div class="vaah-type-caption mb-1" id="nf-error-notifications-1">{{ store.assets.language_strings.error_notifications }}</div>
                                <ToggleSwitch aria-labelledby="nf-error-notifications-1" v-model="store.active_notification.is_error"
                                             data-testid="setting-notification_error"
                                             class="vc-dense"
                                />
                            </span>
                        </div>

                        <div class="col-12 pt-0">
                                                        <Tabs value="0" ref="tabview1" class="vc-dense tab-panel-has-no-padding">
                                <TabList>
                                    <Tab value="0" v-if="store.active_notification.via_mail">{{ store.assets.language_strings.notification_field_mail }}</Tab>
                                    <Tab value="1" v-if="store.active_notification.via_sms">SMS</Tab>
                                    <Tab value="2" v-if="store.active_notification.via_push">{{ store.assets.language_strings.notification_field_push }}</Tab>
                                    <Tab value="3" v-if="store.active_notification.via_backend">{{ store.assets.language_strings.backend }}</Tab>
                                    <Tab value="4" v-if="store.active_notification.via_frontend">{{ store.assets.language_strings.frontend }}</Tab>
                                </TabList>
                                <TabPanels>
                                    <TabPanel value="0" v-if="store.active_notification.via_mail">

                                    <div v-if="store.active_notification.contents" v-for="line in store.active_notification.contents.mail">
                                        <div v-if="line.key == 'subject'" >
                                            <div class="mb-3">
                                                <div class="px-1 vaah-type-caption mb-1" id="nf-notification-field-subject-1">{{ store.assets.language_strings.notification_field_subject }}</div>
                                                <InputText aria-labelledby="nf-notification-field-subject-1" size="small" :placeholder="store.assets.language_strings.placeholder_enter_subject" data-testid="setting-notification_subject" v-model="line.value" class="" />
                                            </div>

                                        </div>
                                        <div v-if="line.key == 'from'">
                                            <div class="mb-3">
                                                <div class="px-1 vaah-type-caption mb-1" id="nf-notification-field-from-1">{{ store.assets.language_strings.notification_field_from }}</div>

                                                <InputText aria-labelledby="nf-notification-field-from-1" size="small" :placeholder="store.assets.language_strings.placeholder_enter_from" v-model="line.meta.name" data-testid="setting-notification_from" class="" />
                                            </div>
                                            <div class="mb-3">
                                                <div class="px-1 vaah-type-caption mb-1" id="nf-notification-field-from-email-1">{{ store.assets.language_strings.notification_field_from_email }}</div>
                                                <InputText aria-labelledby="nf-notification-field-from-email-1" size="small" :placeholder="store.assets.language_strings.placeholder_enter_from" v-model="line.value" data-testid="setting-notification_from_email" class="" />
                                            </div>


                                        </div>
                                    </div>

                                    <div v-if="store.active_notification.contents">
                                        <div v-if="store.active_notification.contents.mail
                                             && store.active_notification.contents.mail.length > 0"
                                             v-for="(line, lineIndex) in store.active_notification.contents.mail">
                                            <div  v-if="line.key == 'line' || line.key == 'greetings'">
                                                <div class="mb-3">
                                                    <!-- UT-135 — the mail contents can
                                                         carry two entries with the
                                                         same key ("line"), so the
                                                         caption's id was not unique
                                                         and landed twice on the
                                                         screen. The row's position
                                                         keeps it unique. -->
                                                    <div class="px-1 vaah-type-caption mb-1" :id="'nf-line-'+line.key+'-'+lineIndex">{{vaah().toLabel(line.key)}}</div>
                                                    <InputGroup>
                                                    <Textarea :aria-labelledby="'nf-line-'+line.key+'-'+lineIndex" size="small" v-model="line.value" v-if="line.key == 'line'" :data-testid="'setting-notification_'+line.key+'_'+lineIndex" :placeholder="store.assets.language_strings.placeholder_content_with_variables" class="" />

                                                        <Textarea v-else
                                                                  v-model="line.value"
                                                                  :auto-resize="true"
                                                                  :aria-labelledby="'nf-line-'+line.key+'-'+lineIndex"
                                                                  :data-testid="'setting-notification_'+line.key+'_'+lineIndex"
                                                                  class="w-full"
                                                                  :placeholder="store.assets.language_strings.placeholder_content_with_variables"
                                                        />

                                                        <Button icon="pi pi-trash" aria-label="Remove content"
                                                                :data-testid="'setting-notification_remove_'+line.key+'_'+lineIndex"
                                                                @click="store.removeContent(line,'mail')"
                                                        />
                                                    </InputGroup>
                                                </div>
                                            </div>

                                            <div  v-if="line.key == 'action'" class="mb-3">
                                                <div class="px-1 vaah-type-caption mb-1" id="nf-notification-field-action-1">{{ store.assets.language_strings.notification_field_action }}</div>
                                                <InputGroup class="vaah-action-row">
                                                    <InputText aria-labelledby="nf-notification-field-action-1" size="small" v-model="line.value" data-testid="setting-notification_action_value" :placeholder="store.assets.language_strings.placeholder_action_label" class="" />

                                                    <Select aria-labelledby="nf-notification-field-action-1" size="small" v-model="line.meta.action" :options="store.notification_actions" optionLabel="name" optionValue="name" data-testid="setting-notification_action_option" :placeholder="store.assets.language_strings.placeholder_choose_an_action" class=" vc-dense" />

                                                    <Button size="small" icon="pi pi-trash" aria-label="Remove action" data-testid="setting-notification_remove_action" @click="store.removeContent(line,'mail')" class="has-max-height" />
                                                </InputGroup>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-content-end">
                                        <Button size="small" :label="store.assets.language_strings.add_subject_button" class="w-auto mr-2" @click="store.addSubject" data-testid="setting-notification_add_subject" :disabled="store.is_add_subject_disabled" />

                                        <Button size="small" :label="store.assets.language_strings.add_from_button" class="w-auto mr-2" @click="store.addFrom" data-testid="setting-notification_add_from" :disabled="store.is_add_from_disabled" />

                                        <Button size="small" :label="store.assets.language_strings.add_greetings_button" @click="store.addToMail('greetings')" data-testid="setting-notification_add_greetings" class="w-auto mr-2" />

                                        <Button size="small" :label="store.assets.language_strings.add_line_button" @click="store.addToMail('line')" data-testid="setting-notification_add_line" class="w-auto mr-2" />

                                        <Button size="small" :label="store.assets.language_strings.add_action_button" @click="store.addAction" data-testid="setting-notification_add_action" class="w-auto" />
                                    </div>
                                                                    </TabPanel>
                                    <TabPanel value="1" v-if="store.active_notification.via_sms">

                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.sms
                                                && store.active_notification.contents.sms.length > 0"
                                         v-for="line in store.active_notification.contents.sms"
                                    >
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <div class="p-1 vaah-type-caption mb-1" id="nf-message-1">Message</div>

                                            <InputGroup>
                                                <Textarea aria-labelledby="nf-message-1" v-model="line.value"
                                                          data-testid="setting-notification_sms_message"
                                                          :autoResize="true" class="w-full"
                                                />
                                            </InputGroup>
                                        </div>
                                    </div>

                                    <div v-else>

                                        <Message
                                            severity="info" :closable="false" class="text-center pt-3">
                                            <p><i class="pi pi-sync"></i></p>
                                            <p>{{ store.assets.language_strings.content_message }}</p>

                                            <Button size="small" :label="store.assets.language_strings.add_content_button" data-testid="setting-notification_add_sms" @click="store.addSmsContent" class="w-auto my-3" />
                                        </Message>

                                    </div>
                                                                    </TabPanel>
                                    <TabPanel value="2" v-if="store.active_notification.via_push">

                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.push
                                                && store.active_notification.contents.push.length > 0"
                                         v-for="line in store.active_notification.contents.push"
                                    >
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <div class="p-1 vaah-type-caption mb-1" id="nf-notification-field-message-1">{{ store.assets.language_strings.notification_field_message }}</div>

                                            <InputGroup>
                                                <Textarea aria-labelledby="nf-notification-field-message-1" v-model="line.value"
                                                          data-testid="setting-notification_push_message"
                                                          :autoResize="true" class="w-full"
                                                />
                                            </InputGroup>
                                        </div>

                                        <div class="col-12 px-0" v-if="line.key == 'action'">
                                            <div class="p-1 vaah-type-caption mb-1" id="nf-notification-field-action-2">{{ store.assets.language_strings.notification_field_action }}</div>

                                            <InputGroup>
                                                <InputText aria-labelledby="nf-notification-field-action-2" size="small" :placeholder="store.assets.language_strings.placeholder_action_label" v-model="line.value" data-testid="setting-notification_push_action" inputClass="" />

                                                <Select aria-labelledby="nf-notification-field-action-2" size="small" :placeholder="store.assets.language_strings.placeholder_choose_an_action" v-model="line.meta.action" :options="store.notification_actions" optionLabel="name" optionValue="name" data-testid="setting-notification_push_message_copy" inputClass="" />
                                            </InputGroup>
                                        </div>
                                    </div>

                                    <div v-else>
                                        <Message
                                            severity="info" :closable="false" class="text-center pt-3">
                                            <p><i class="pi pi-sync"></i></p>
                                            <p>{{ store.assets.language_strings.content_message }}</p>
                                            <Button size="small" :label="store.assets.language_strings.add_content_button" data-testid="setting-notification_add_push" @click="store.addPushContent" class="w-auto my-3" />

                                        </Message>

                                    </div>
                                                                    </TabPanel>
                                    <TabPanel value="3" v-if="store.active_notification.via_backend">

                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.backend
                                                && store.active_notification.contents.backend.length > 0"
                                         v-for="line in store.active_notification.contents.backend"
                                    >
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <div class="p-1 vaah-type-caption mb-1" id="nf-notification-field-message-2">{{ store.assets.language_strings.notification_field_message }}</div>

                                            <InputGroup>
                                                <Textarea aria-labelledby="nf-notification-field-message-2" v-model="line.value"
                                                          data-testid="setting-notification_backend_message"
                                                          :autoResize="true" class="w-full"
                                                />
                                            </InputGroup>
                                        </div>

                                        <div class="col-12 px-0" v-if="line.key == 'action'">
                                            <div class="p-1 vaah-type-caption mb-1" id="nf-notification-field-action-3">{{ store.assets.language_strings.notification_field_action }}</div>
                                            <InputGroup>
                                                <InputText aria-labelledby="nf-notification-field-action-3" size="small" :placeholder="store.assets.language_strings.placeholder_action_label" v-model="line.value" data-testid="setting-notification_backend_action" inputClass="" />
                                                <Select aria-labelledby="nf-notification-field-action-3" size="small" :placeholder="store.assets.language_strings.placeholder_choose_an_action" v-model="line.meta.action" :options="store.notification_actions" optionLabel="name" optionValue="name" data-testid="setting-notification_backend_message_copy" inputClass="" />
                                            </InputGroup>
                                        </div>
                                    </div>

                                    <div v-else>
                                        <Message
                                            severity="info" :closable="false" class="text-center pt-3">
                                            <p><i class="pi pi-sync"></i></p>
                                            <p>{{ store.assets.language_strings.content_message }}</p>

                                            <Button size="small" :label="store.assets.language_strings.add_content_button" data-testid="setting-notification_add_backend" @click="store.addBackendContent" class="w-auto my-3" />

                                        </Message>

                                    </div>
                                                                    </TabPanel>
                                    <TabPanel value="4" v-if="store.active_notification.via_frontend">

                                    <div v-if=" store.active_notification.contents && store.active_notification.contents.frontend
                                                && store.active_notification.contents.frontend.length > 0"
                                         v-for="line in store.active_notification.contents.frontend"
                                    >
                                        <div class="col-12 px-0" v-if="line.key == 'content'">
                                            <div class="p-1 vaah-type-caption mb-1" id="nf-notification-field-message-3">{{ store.assets.language_strings.notification_field_message }}</div>

                                            <InputGroup>
                                                <Textarea aria-labelledby="nf-notification-field-message-3" v-model="line.value"
                                                          data-testid="setting-notification_frontend_message"
                                                          :autoResize="true" class="w-full"
                                                />
                                            </InputGroup>
                                        </div>

                                        <div class="col-12 px-0" v-if="line.key == 'action'">
                                            <div class="p-1 vaah-type-caption mb-1" id="nf-notification-field-action-4">{{ store.assets.language_strings.notification_field_action }}</div>

                                            <InputGroup>
                                                <InputText aria-labelledby="nf-notification-field-action-4" size="small" :placeholder="store.assets.language_strings.placeholder_action_label" v-model="line.value" data-testid="setting-notification_frontend_action" inputClass="" />
                                                <Select aria-labelledby="nf-notification-field-action-4" size="small" :placeholder="store.assets.language_strings.placeholder_choose_an_action" v-model="line.meta.action" :options="store.notification_actions" optionLabel="name" optionValue="name" data-testid="setting-notification_frontendv_message_copy" inputClass="" />
                                            </InputGroup>
                                        </div>
                                    </div>

                                    <div v-else>
                                        <Message
                                            severity="info" :closable="false" class="text-center pt-3">
                                            <p><i class="pi pi-sync"></i></p>
                                            <p>{{ store.assets.language_strings.content_message }}</p>

                                            <Button size="small" :label="store.assets.language_strings.add_content_button" data-testid="setting-notification_add_frontend" @click="store.addFrontendContent" class="w-auto my-3" />
                                        </Message>

                                    </div>
                                                                    </TabPanel>
                                </TabPanels>
                            </Tabs>
                            <Divider class="mb-3 mt-0" />
                            <div class="flex justify-content-end">
                                <Button size="small" :label="store.assets.language_strings.notification_save_button" icon="pi pi-save" data-testid="setting-notification_store" @click="store.storeNotification" class="w-auto mr-3" />

                                <Button size="small" :label="store.assets.language_strings.notification_test_button" data-testid="setting-notification_test" @click="store.is_testing=true" icon="pi pi-reply" class="w-auto" />
                            </div>

                            <InputGroup class="mt-3">
                                <!-- UT-135 — the recipient picker carried no
                                     accessible name (the `placeholde` typo
                                     meant the placeholder never reached the
                                     input either), so a screen reader
                                     announced an unnamed combo box. -->
                                <AutoComplete size="small" v-model="store.send_to" :suggestions="store.user_list" @complete="store.searchUser($event)" optionLabel="name" optionValue="email" placeholder="Search..." aria-label="Search recipient" data-testid="setting-notification_send_to" inputClass="" />

                                <Button size="small" :label="store.assets.language_strings.notification_test_send_button" data-testid="setting-notification_test_send" @click="store.sendNotification" icon="pi pi-reply" class="w-auto" />
                            </InputGroup>
                        </div>
                    </div>
                </Panel>

            </Fluid>
        </div>
</template>

<style scoped>

</style>
