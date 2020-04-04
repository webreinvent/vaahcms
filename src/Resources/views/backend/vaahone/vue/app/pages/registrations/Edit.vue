<script src="./EditJs.js"></script>
<template>
    <div class="column" v-if="page.assets && item">

        <div class="card">

            <!--header-->
            <header class="card-header">

                <div class="card-header-title">
                    <span>{{$vaah.limitString(item.name, 25)}}</span>
                </div>


                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button type="is-light">
                                <vh-copy
                                    :data="item.id"
                                    :confirm_dialog="'buefy'">
                                    <small><b>#{{item.id}}</b></small>
                                </vh-copy>
                            </b-button>
                        </p>

                        <p class="control">
                            <b-button icon-left="save"
                                      type="is-light"
                                      :loading="is_btn_loading"
                                      @click="store()">
                                Save
                            </b-button>
                        </p>

                        <p class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button is-light"
                                        slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-close')">
                                    <b-icon icon="check"></b-icon>
                                    Save & Close
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-new')">
                                    <b-icon icon="plus"></b-icon>
                                    Save & New
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 @click="setLocalAction('save-and-clone')">
                                    <b-icon icon="copy"></b-icon>
                                    Save & Clone
                                </b-dropdown-item>

                            </b-dropdown>


                        </p>

                        <p class="control">
                            <b-button tag="router-link"
                                      type="is-light"
                                      :to="{name: 'reg.view', params:{id:item.id}}"
                                      icon-left="times">
                            </b-button>
                        </p>



                    </div>


                </div>

            </header>
            <!--/header-->

            <!--content-->
            <div class="card-content">
                <div class="block">

                    <b-field label="Email" :label-position="labelPosition">
                        <b-input type="email"  name="register-email" dusk="register-email"
                                 v-model="item.email"></b-input>
                    </b-field>


                    <b-field label="Username" :label-position="labelPosition">
                        <b-input v-model="item.username"  name="register-username"
                                 dusk="register-username" ></b-input>
                    </b-field>

                    <b-field label="New Password" :label-position="labelPosition">
                        <b-input type="password" v-model="item.password"
                                 name="register-password" dusk="register-password" ></b-input>
                    </b-field>

                    <b-field label="Display Name" :label-position="labelPosition">
                        <b-input v-model="item.display_name"
                                 name="register-display_name" dusk="register-display_name" >
                        </b-input>
                    </b-field>

                    <b-field label="Title" :label-position="labelPosition">
                        <b-select placeholder="Select a title"
                                  name="register-title" dusk="register-title"
                                  v-model="item.title">
                            <option v-for="title in page.assets.name_titles"
                                    :value="title.slug"
                            >{{title.name}}</option>
                        </b-select>
                    </b-field>



                    <b-field label="First Name" :label-position="labelPosition">
                        <b-input v-model="item.first_name"
                                 name="register-first_name" dusk="register-first_name"
                        ></b-input>
                    </b-field>

                    <b-field label="Middle Name" :label-position="labelPosition">
                        <b-input v-model="item.middle_name"
                                 name="register-middle_name" dusk="register-middle_name"
                        ></b-input>
                    </b-field>

                    <b-field label="Last Name" :label-position="labelPosition">
                        <b-input v-model="item.last_name"
                                 name="register-last_name" dusk="register-last_name"
                        ></b-input>
                    </b-field>

                    <b-field label="Gender" :label-position="labelPosition">
                        <b-radio-button v-model="item.gender"
                                        name="register-gender" dusk="register-gender"
                                        native-value="m">
                            <b-icon icon="mars"></b-icon>
                            <span>Male</span>
                        </b-radio-button>

                        <b-radio-button v-model="item.gender"
                                        name="register-gender" dusk="register-gender"
                                        native-value="f">
                            <b-icon icon="venus"></b-icon>
                            <span>Female</span>
                        </b-radio-button>

                        <b-radio-button v-model="item.gender"
                                        name="register-gender" dusk="register-gender"
                                        native-value="o">
                            <b-icon icon="transgender-alt"></b-icon>
                            <span>Other</span>
                        </b-radio-button>


                    </b-field>

                    <b-field label="Country Code" :label-position="labelPosition">
                        <b-select placeholder="Select a country code"
                                  name="register-country_code" dusk="register-country_code"
                                  v-model="item.country_calling_code">
                            <option v-for="code in page.assets.country_calling_code"
                                    :value="code.calling_code"
                            >{{code.calling_code}}</option>
                        </b-select>
                    </b-field>

                    <b-field label="Phone" :label-position="labelPosition">
                        <b-input v-model="item.phone"
                                 name="register-phone" dusk="register-phone"
                        ></b-input>
                    </b-field>

                    <b-field label="Timezone" :label-position="labelPosition">
                        <AutoCompleteTimeZone
                            :selected_value="item.timezone"
                            :options="page.assets.timezones"
                            :open_on_focus="true"
                            @onSelect="setTimeZone"
                        />
                    </b-field>

                    <b-field label="Alternate Email" :label-position="labelPosition">
                        <b-input type="email" v-model="item.alternate_email"
                                 name="register-alternate_email" dusk="register-alternate_email"
                        ></b-input>
                    </b-field>

                    <b-field label="Date of Birth" :label-position="labelPosition">
                        <DatePicker
                            :selected_value="item.birth"
                            @onSelect="setBirthDate"/>
                    </b-field>

                    <b-field label="Country" :label-position="labelPosition">
                        <AutoCompleteCountry
                            :selected_value="item.country"
                            :options="page.assets.countries"
                            :open_on_focus="true"
                            @onSelect="setCountry"
                        />
                    </b-field>

                    <b-field label="Status" :label-position="labelPosition">
                        <b-select placeholder="Select a status"
                                  name="register-status" dusk="register-status"
                                  v-model="item.status">
                            <option v-for="status in page.assets.registration_statuses"
                                    :value="status.slug"
                            >{{status.name}}</option>
                        </b-select>
                    </b-field>


                </div>
            </div>
            <!--/content-->





        </div>




    </div>
</template>


