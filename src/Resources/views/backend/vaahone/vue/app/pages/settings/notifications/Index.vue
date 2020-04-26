<script src="./IndexJs.js"></script>
<template>
    <div class="form-page-v1-layout">

        <div class="container" >

            <div class="columns">

                <!--left-->
                <div class="column">

                    <!--card-->
                    <div class="card" >

                        <!--header-->
                        <header class="card-header">

                            <div class="card-header-title">
                                General
                            </div>

                            <div class="card-header-buttons">
                                <div class="field has-addons is-pulled-right">
                                    <p  class="control">
                                        <b-button type="is-light"
                                                  icon-left="plus">
                                            Add
                                        </b-button>
                                    </p>
                                </div>
                            </div>

                        </header>
                        <!--/header-->

                        <!--content-->
                        <div class="card-content" v-if="assets && assets.notification_variables.length>0">


                            <div class="columns">

                                <div class="column is-3">

                                    <b-field v-for="variable in assets.notification_variables"
                                             :key="variable.name"
                                            :message="variable.details">

                                        <b-field >

                                            <b-input v-model="variable.name"></b-input>

                                            <p class="control">
                                                <b-button
                                                    @click="$vaah.copy(variable.name)"
                                                    icon-left="copy"></b-button>
                                            </p>

                                        </b-field>

                                    </b-field>


                                </div>
                                <div class="column is-9">

                                    <AutoComplete :options="assets.notifications"
                                                  @onSelect="setActiveItem"
                                                  :open_on_focus="true"

                                    />

                                    <hr/>

                                    <div v-if="page.active_item">

                                    <b-field label="Deliver via">

                                        <div class="block">


                                            <b-switch size="is-small"
                                                      v-model="active_item.via_mail">
                                                Mail
                                            </b-switch>

                                            <b-switch size="is-small"
                                                      v-model="active_item.via_sms">
                                                SMS
                                            </b-switch>

                                            <b-switch size="is-small"
                                                      v-model="active_item.via_push">
                                                Push
                                            </b-switch>

                                            <b-switch size="is-small"
                                                      v-model="active_item.via_backend">
                                                Backend
                                            </b-switch>

                                            <b-switch size="is-small"
                                                      v-model="active_item.via_frontend">
                                                Frontend
                                            </b-switch>


                                        </div>

                                    </b-field>


                                        <b-field label="Is this an error notifications?">

                                            <div class="block">


                                                <b-switch size="is-small"
                                                          v-model="active_item.is_errors">
                                                    Yes
                                                </b-switch>



                                            </div>

                                        </b-field>

                                    <section>

                                        <b-tabs >
                                            <b-tab-item :visible="active_item.via_mail"
                                                        label="Mail">


                                                <div v-if="active_item.contents" class="has-margin-bottom-15">
                                                    <div v-if="active_item.contents.mail
                                                    && active_item.contents.mail.length > 0"
                                                         v-for="line in active_item.contents.mail">
                                                        <b-field v-if="line.key == 'from' || line.key == 'from_email' ">
                                                            <p class="control">
                                                                <span class="button is-static">{{$vaah.toLabel(line.key)}}</span>
                                                            </p>
                                                            <b-input :placeholder="$vaah.toLabel(line.key)"
                                                                     v-model="line.value"
                                                                     expanded></b-input>

                                                        </b-field>
                                                    </div>
                                                </div>



                                                <div v-if="active_item.contents">
                                                    <div v-if="active_item.contents.mail
                                                    && active_item.contents.mail.length > 0"
                                                         v-for="line in active_item.contents.mail">
                                                        <b-field v-if="line.key != 'action'">
                                                            <b-field v-if="line.key != 'from' && line.key != 'from_email' ">
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
                                                                    <b-button icon-left="trash"></b-button>
                                                                </p>

                                                            </b-field>
                                                        </b-field>

                                                        <b-field v-else>

                                                            <b-field v-if="line.key != 'from' && line.key != 'from_email' ">
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
                                                                        v-for="option in assets.notification_actions"
                                                                        :value="option.name"
                                                                        :key="option.name">
                                                                        {{ option.name }}
                                                                    </option>
                                                                </b-select>

                                                                <p class="control">
                                                                    <b-button icon-left="trash"></b-button>
                                                                </p>

                                                            </b-field>

                                                        </b-field>


                                                    </div>
                                                </div>


                                                <div class="has-margin-top-15">

                                                    <b-button @click="addFrom()">Add From</b-button>
                                                    <b-button @click="addToMail('greetings')">Add Greetings</b-button>
                                                    <b-button @click="addToMail('line')">Add Line</b-button>
                                                    <b-button @click="addAction()">Add Action</b-button>

                                                </div>

                                                <hr/>
                                                <b-button type="is-primary" @click="store()">Save</b-button>
                                                <b-button type="is-primary">Send Test Notification</b-button>


                                            </b-tab-item>

                                            <b-tab-item :visible="active_item.via_sms"
                                                        label="SMS">

                                                <div v-if=" active_item.contents && active_item.contents.sms
                                                && active_item.contents.sms.length > 0">

                                                    <b-field v-for="line in active_item.contents.sms">

                                                        <b-field v-if="line.key == 'content'">
                                                            <p class="control">
                                                                <span class="button is-static">Message</span>
                                                            </p>
                                                            <b-input expanded v-model="line.value" type="textarea">

                                                            </b-input>
                                                        </b-field>





                                                    </b-field>

                                                    <hr/>
                                                    <b-button type="is-primary" @click="store()">Save</b-button>
                                                    <b-button type="is-primary">Send Test Notification</b-button>
                                                </div>
                                                <div v-else>
                                                    <b-button @click="addSmsContent">Add Content</b-button>
                                                </div>



                                            </b-tab-item>

                                            <b-tab-item :visible="active_item.via_push"
                                                        label="Push">

                                                <div v-if=" active_item.contents && active_item.contents.push
                                                && active_item.contents.push.length > 0">

                                                    <b-field v-for="line in active_item.contents.push">

                                                        <b-field v-if="line.key == 'content'">
                                                            <p class="control">
                                                                <span class="button is-static">Message</span>
                                                            </p>
                                                            <b-input expanded v-model="line.value" type="textarea">

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
                                                                    v-for="option in assets.notification_actions"
                                                                    :value="option.name"
                                                                    :key="option.name">
                                                                    {{ option.name }}
                                                                </option>
                                                            </b-select>

                                                        </b-field>

                                                    </b-field>

                                                    <hr/>
                                                    <b-button type="is-primary" @click="store()">Save</b-button>
                                                    <b-button type="is-primary">Send Test Notification</b-button>
                                                </div>
                                                <div v-else>
                                                    <b-button @click="addPushContent">Add Content</b-button>
                                                </div>



                                            </b-tab-item>



                                            <b-tab-item :visible="active_item.via_backend"
                                                        label="Backend">
                                                <div v-if=" active_item.contents && active_item.contents.backend
                                                && active_item.contents.backend.length > 0">

                                                    <b-field v-for="line in active_item.contents.backend">

                                                        <b-field v-if="line.key == 'content'">
                                                            <p class="control">
                                                                <span class="button is-static">Message</span>
                                                            </p>
                                                            <b-input expanded v-model="line.value" type="textarea">

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
                                                                    v-for="option in assets.notification_actions"
                                                                    :value="option.name"
                                                                    :key="option.name">
                                                                    {{ option.name }}
                                                                </option>
                                                            </b-select>

                                                        </b-field>

                                                    </b-field>

                                                    <hr/>
                                                    <b-button type="is-primary" @click="store()">Save</b-button>
                                                    <b-button type="is-primary">Send Test Notification</b-button>
                                                </div>
                                                <div v-else>
                                                    <b-button @click="addBackendContent()">Add Content</b-button>
                                                </div>
                                            </b-tab-item>

                                            <b-tab-item :visible="active_item.via_frontend"
                                                        label="Frontend">
                                                <div v-if=" active_item.contents && active_item.contents.frontend
                                                && active_item.contents.frontend.length > 0">

                                                    <b-field v-for="line in active_item.contents.frontend">

                                                        <b-field v-if="line.key == 'content'">
                                                            <p class="control">
                                                                <span class="button is-static">Message</span>
                                                            </p>
                                                            <b-input expanded v-model="line.value" type="textarea">

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
                                                                    v-for="option in assets.notification_actions"
                                                                    :value="option.name"
                                                                    :key="option.name">
                                                                    {{ option.name }}
                                                                </option>
                                                            </b-select>

                                                        </b-field>

                                                    </b-field>

                                                    <hr/>
                                                    <b-button type="is-primary" @click="store()">Save</b-button>
                                                    <b-button type="is-primary">Send Test Notification</b-button>
                                                </div>
                                                <div v-else>
                                                    <b-button @click="addFrontendContent">Add Content</b-button>
                                                </div>
                                            </b-tab-item>

                                        </b-tabs>
                                    </section>


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


