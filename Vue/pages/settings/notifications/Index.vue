<script src="./IndexJs.js"></script>
<template>
    <div class="settings-notifications">

        <div class="container" v-if="assets">

            <div class="columns">

                <!--left-->
                <div class="column">

                    <!--card-->
                    <div class="card" >

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                Notifications
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  @click="show_new_item_form = $vaah.toggle(show_new_item_form)"
                                                  icon-left="plus">
                                            Add
                                        </b-button>
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content" >


                            <div class="columns">

                                <div class="column is-3" v-if="assets.notification_variables">

                                    <b-field v-for="variable in assets.notification_variables.success"
                                             :key="variable.name">

                                        <b-field >

                                            <b-input v-model="variable.name"></b-input>

                                            <b-tooltip label="Copy" type="is-dark">
                                                <p class="control">
                                                    <b-button
                                                        @click="$vaah.copy(variable.name)"
                                                        icon-left="copy"></b-button>
                                                </p>
                                            </b-tooltip>



                                            <b-tooltip :label="variable.details" type="is-dark">
                                                <p class="control">
                                                    <b-button icon-left="question-circle"></b-button>
                                                </p>
                                            </b-tooltip>


                                        </b-field>

                                    </b-field>


                                </div>
                                <div class="column is-9">

                                    <div v-if="show_new_item_form">

                                        <b-notification type="is-danger" :closable="false"
                                                        class="is-light is-small has-margin-bottom-5">
                                            These are notifications needs to be send manually.
                                        </b-notification>

                                        <b-field grouped   >

                                            <b-field expanded>
                                                <b-input v-model="new_item.name"
                                                         expanded
                                                         placeholder="Enter new notification name"></b-input>
                                                <p class="control">
                                                    <b-button type="is-light"
                                                              @click="create()"
                                                              icon-left="save">
                                                        Save
                                                    </b-button>
                                                </p>
                                            </b-field>
                                        </b-field>

                                        <hr/>

                                    </div>




                                    <b-field grouped  v-if="assets && assets.notifications.length>0">
                                        <b-field expanded>
                                            <AutoComplete :options="assets.notifications"
                                                          @onSelect="setActiveItem"
                                                          :open_on_focus="true"

                                            />

                                        </b-field>
                                    </b-field>



                                    <hr/>

                                    <div v-if="page.active_item">

                                        <h3 class="title is-4">
                                            <b-button v-if="assets.help_urls && assets.help_urls.send_notification" tag="a"
                                                      :href="assets.help_urls.send_notification"
                                                      target="_blank"
                                                      icon-left="question-circle"></b-button>
                                            <b-tooltip label="Copy Slug" type="is-dark">
                                                <b-button @click="$vaah.copy(page.active_item.slug)">
                                                    <b-icon class="is-clickable icon is-small"
                                                            icon="copy">
                                                    </b-icon>
                                                </b-button>
                                            </b-tooltip>
                                            {{page.active_item.name}}

                                        </h3>




                                        <b-field label="Deliver via">

                                        <div class="block">


                                            <b-switch size="is-small"
                                                      type="is-success"
                                                      v-model="active_item.via_mail">
                                                Mail
                                            </b-switch>

                                            <b-switch size="is-small"
                                                      type="is-success"
                                                      v-model="active_item.via_sms">
                                                SMS
                                            </b-switch>

                                            <b-switch size="is-small"
                                                      type="is-success"
                                                      v-model="active_item.via_push">
                                                Push
                                            </b-switch>

                                            <b-switch size="is-small"
                                                      type="is-success"
                                                      v-model="active_item.via_backend">
                                                Backend
                                            </b-switch>

                                            <b-switch size="is-small"
                                                      type="is-success"
                                                      v-model="active_item.via_frontend">
                                                Frontend
                                            </b-switch>


                                        </div>

                                    </b-field>


                                        <b-field label="Is this an error notifications?">

                                            <div class="block">

                                                <b-switch size="is-small"
                                                          type="is-danger"
                                                          v-model="active_item.is_error">
                                                    Yes
                                                </b-switch>


                                            </div>

                                        </b-field>

                                        <section>

                                        <b-tabs >
                                            <b-tab-item :visible="active_item.via_mail"
                                                        label="Mail">

                                                <div class="notification-lines" v-if="active_item.contents">

                                                    <div v-if="active_item.contents.mail
                                                    && active_item.contents.mail.length > 0"
                                                         class="has-margin-bottom-15">
                                                    <div v-for="line in active_item.contents.mail">

                                                        <div v-if="line.key == 'subject'">

                                                            <b-field >
                                                                <p class="control">
                                                                    <span class="button is-static">Subject</span>
                                                                </p>
                                                                <b-input placeholder="Subject"
                                                                         v-model="line.value"
                                                                         expanded></b-input>

                                                            </b-field>


                                                        </div>

                                                        <div v-if="line.key == 'from'">

                                                            <b-field >
                                                                <p class="control">
                                                                    <span class="button is-static">From</span>
                                                                </p>
                                                                <b-input placeholder="From name"
                                                                         v-model="line.meta.name"
                                                                         expanded></b-input>
                                                            </b-field>


                                                            <b-field>
                                                                <p class="control">
                                                                    <span class="button is-static">From Email</span>
                                                                </p>
                                                                <b-input placeholder="From email"
                                                                         v-model="line.value"
                                                                         expanded></b-input>
                                                            </b-field>

                                                        </div>


                                                    </div>
                                                </div>

                                                    <div  v-if="active_item.contents">
                                                    <div v-if="active_item.contents.mail
                                                    && active_item.contents.mail.length > 0"
                                                         v-for="line in active_item.contents.mail">

                                                        <b-field v-if="line.key == 'line' || line.key == 'greetings'">
                                                            <b-field >
                                                                <p class="control">
                                                                    <span class="button is-static">{{$vaah.toLabel(line.key)}}</span>
                                                                </p>
                                                                <b-input placeholder="Content with variables"
                                                                         v-if="line.key == 'line'"
                                                                         type="textarea"
                                                                         v-model="line.value"
                                                                         expanded></b-input>

                                                                <b-input placeholder="Content with variables"
                                                                         v-else
                                                                         type="text"
                                                                         v-model="line.value"
                                                                         expanded></b-input>

                                                                <p class="control">
                                                                    <b-button @click="removeContent(line, 'mail')"
                                                                              icon-left="trash"></b-button>
                                                                </p>

                                                            </b-field>
                                                        </b-field>

                                                        <b-field v-if="line.key == 'action' ">

                                                            <b-field >
                                                                <p class="control">
                                                                    <span class="button is-static">{{$vaah.toLabel(line.key)}}</span>
                                                                </p>
                                                                <b-input placeholder="Action Label"
                                                                         v-model="line.value"
                                                                         expanded></b-input>
                                                                <b-select v-model="line.meta.action" placeholder="Select an action">
                                                                    <option
                                                                        value=""
                                                                        key="">
                                                                        Select an action
                                                                    </option>
                                                                    <option
                                                                        v-for="option in assets.notification_actions.success"
                                                                        :value="option.name"
                                                                        :key="option.name">
                                                                        {{ option.name }}
                                                                    </option>
                                                                </b-select>

                                                                <p class="control">
                                                                    <b-button @click="removeContent(line, 'mail')" icon-left="trash"></b-button>
                                                                </p>

                                                            </b-field>

                                                        </b-field>


                                                    </div>
                                                </div>
                                                </div>

                                                <div class="has-margin-top-15">
                                                    <b-button @click="addSubject()"
                                                              :disabled="page.is_add_subject_disabled">
                                                        Add Subject
                                                    </b-button>
                                                    <b-button @click="addFrom()"
                                                              :disabled="page.is_add_from_disabled">
                                                        Add From
                                                    </b-button>
                                                    <b-button @click="addToMail('greetings')">
                                                        Add Greetings
                                                    </b-button>
                                                    <b-button @click="addToMail('line')">
                                                        Add Line
                                                    </b-button>
                                                    <b-button @click="addAction()">
                                                        Add Action
                                                    </b-button>
                                                </div>





                                            </b-tab-item>

                                            <b-tab-item :visible="active_item.via_sms"
                                                        key="sms"
                                                        label="SMS">

                                                <div v-if=" active_item.contents && active_item.contents.sms
                                                && active_item.contents.sms.length > 0">

                                                    <div class="notification-lines">
                                                    <b-field v-for="line in active_item.contents.sms"
                                                             :key="'sms'+line.sort">

                                                        <b-field v-if="line.key == 'content'">
                                                            <p class="control">
                                                                <span class="button is-static">Message</span>
                                                            </p>
                                                            <b-input expanded v-model="line.value"
                                                                     maxlength="200"
                                                                     type="textarea">

                                                            </b-input>
                                                        </b-field>

                                                    </b-field>
                                                    </div>


                                                </div>
                                                <div v-else>
                                                    <b-button @click="addSmsContent">Add Content</b-button>
                                                </div>



                                            </b-tab-item>

                                            <b-tab-item :visible="active_item.via_push"
                                                        key="push"
                                                        label="Push">

                                                <div v-if=" active_item.contents && active_item.contents.push
                                                && active_item.contents.push.length > 0">

                                                    <div class="notification-lines">
                                                    <b-field v-for="line in active_item.contents.push"
                                                             :key="'push'+line.sort">

                                                        <b-field v-if="line.key == 'content'">
                                                            <p class="control">
                                                                <span class="button is-static">Message</span>
                                                            </p>
                                                            <b-input expanded v-model="line.value"
                                                                     maxlength="200"
                                                                     type="textarea">

                                                            </b-input>
                                                        </b-field>

                                                        <b-field v-if="line.key == 'action'">
                                                            <p class="control">
                                                                <span class="button is-static">Action Label</span>
                                                            </p>
                                                            <b-input placeholder="Action Label"
                                                                     v-model="line.value"
                                                                     expanded></b-input>
                                                            <b-select v-model="line.meta.action" placeholder="Select an action">
                                                                <option
                                                                    value=""
                                                                    key="">
                                                                    Select an action
                                                                </option>
                                                                <option
                                                                    v-for="option in assets.notification_actions.success"
                                                                    :value="option.name"
                                                                    :key="option.name">
                                                                    {{ option.name }}
                                                                </option>
                                                            </b-select>

                                                        </b-field>

                                                    </b-field>
                                                    </div>


                                                </div>
                                                <div v-else>
                                                    <b-button @click="addPushContent">Add Content</b-button>
                                                </div>



                                            </b-tab-item>



                                            <b-tab-item :visible="active_item.via_backend"
                                                        key="backend"
                                                        label="Backend">
                                                <div v-if=" active_item.contents && active_item.contents.backend
                                                && active_item.contents.backend.length > 0">

                                                    <b-field v-for="line in active_item.contents.backend"
                                                             :key="'backend'+line.sort">
                                                        <div class="notification-lines">
                                                        <b-field v-if="line.key == 'content'">
                                                            <p class="control">
                                                                <span class="button is-static">Message</span>
                                                            </p>
                                                            <b-input expanded v-model="line.value"
                                                                     type="textarea">

                                                            </b-input>
                                                        </b-field>

                                                        <b-field v-if="line.key == 'action'">
                                                            <p class="control">
                                                                <span class="button is-static">Action Label</span>
                                                            </p>
                                                            <b-input placeholder="Action Label"
                                                                     v-model="line.value"
                                                                     expanded></b-input>
                                                            <b-select v-model="line.meta.action" placeholder="Select an action">
                                                                <option
                                                                    value=""
                                                                    key="">
                                                                    Select an action
                                                                </option>
                                                                <option
                                                                    v-for="option in assets.notification_actions.success"
                                                                    :value="option.name"
                                                                    :key="option.name">
                                                                    {{ option.name }}
                                                                </option>
                                                            </b-select>

                                                        </b-field>

                                                        </div>
                                                    </b-field>


                                                </div>
                                                <div v-else>
                                                    <b-button @click="addBackendContent()">Add Content</b-button>
                                                </div>
                                            </b-tab-item>

                                            <b-tab-item :visible="active_item.via_frontend"
                                                        key="frontend"
                                                        label="Frontend">
                                                <div v-if=" active_item.contents && active_item.contents.frontend
                                                && active_item.contents.frontend.length > 0">

                                                    <div class="notification-lines">
                                                    <b-field v-for="line in active_item.contents.frontend"
                                                             :key="'frontend'+line.sort">

                                                        <b-field v-if="line.key == 'content'">
                                                            <p class="control">
                                                                <span class="button is-static">Message</span>
                                                            </p>
                                                            <b-input expanded
                                                                     v-model="line.value" type="textarea">

                                                            </b-input>
                                                        </b-field>

                                                        <b-field v-if="line.key == 'action'">
                                                            <p class="control">
                                                                <span class="button is-static">Action Label</span>
                                                            </p>
                                                            <b-input placeholder="Action Label"
                                                                     v-model="line.value"
                                                                     expanded></b-input>
                                                            <b-select v-model="line.meta.action" placeholder="Select an action">
                                                                <option
                                                                    value=""
                                                                    key="">
                                                                    Select an action
                                                                </option>
                                                                <option
                                                                    v-for="option in assets.notification_actions.success"
                                                                    :value="option.name"
                                                                    :key="option.name">
                                                                    {{ option.name }}
                                                                </option>
                                                            </b-select>

                                                        </b-field>

                                                    </b-field>

                                                    </div>

                                                </div>
                                                <div v-else>
                                                    <b-button @click="addFrontendContent">Add Content</b-button>
                                                </div>
                                            </b-tab-item>

                                        </b-tabs>


                                    </section>

                                        <div class="columns has-margin-top-10">

                                            <div class="column is-3">
                                                <b-field>
                                                    <p class="control">
                                                        <b-button type="is-light"
                                                                  @click="store()"
                                                                  icon-left="save">
                                                            Save
                                                        </b-button>
                                                    </p>

                                                    <p class="control" >
                                                        <b-button  type="is-light"
                                                                   @click="is_testing=true"
                                                                   icon-left="share">
                                                            Test
                                                        </b-button>
                                                    </p>
                                                </b-field>

                                            </div>
                                            <div class="column is-8">

                                                <div v-if="is_testing">

                                                    <b-field expanded>
                                                        <AutoCompleteUsers @onSelect="setSendTo"/>

                                                        <p class="control" >
                                                            <b-button  type="is-light"
                                                                       @click="sendNotification()"
                                                                       :loading="is_sending"
                                                                       icon-left="share">
                                                                Send
                                                            </b-button>
                                                        </p>
                                                    </b-field>


                                                </div>

                                            </div>

                                        </div>

                                    </div>





                                </div>

                            </div>



                        </div>
                        <!--/content-->

                    </div>
                    <!--/card-->


                </div>
                <!--/left-->



            </div>


        </div>



    </div>
</template>


