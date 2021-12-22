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
                            <b-button @click="$vaah.copy(item.id)"  type="is-light">
                                <small><b>#{{item.id}}</b></small>
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
                            <b-button type="is-light"
                                      tag="router-link"
                                      :to="{name:'reg.view', params:{id: item.id}}"
                                      icon-left="eye">
                            </b-button>
                        </p>

                        <p class="control">
                            <b-button type="is-light"
                                      @click="resetActiveItem()"
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


                    <b-field v-if="!isHidden('username')"
                             label="Username" :label-position="labelPosition">
                        <b-input v-model="item.username"  name="register-username"
                                 dusk="register-username" ></b-input>
                    </b-field>

                    <b-field label="New Password" :label-position="labelPosition">
                        <b-input type="password" v-model="item.password"
                                 name="register-password" dusk="register-password" ></b-input>
                    </b-field>

                    <b-field v-if="!isHidden('display_name')"
                             label="Display Name" :label-position="labelPosition">
                        <b-input v-model="item.display_name"
                                 name="register-display_name" dusk="register-display_name" >
                        </b-input>
                    </b-field>

                    <b-field v-if="!isHidden('title')"
                             label="Title" :label-position="labelPosition">
                        <b-select placeholder="Select a title"
                                  name="register-title" dusk="register-title"
                                  v-model="item.title">
                            <option v-for="title in page.assets.name_titles"
                                    :value="title.slug"
                            >{{title.name}}</option>
                        </b-select>
                    </b-field>

                    <b-field v-if="!isHidden('designation')"
                             label="Designation" :label-position="labelPosition">
                        <b-input v-model="item.designation"
                                 name="register-designation" dusk="register-designation"
                        ></b-input>
                    </b-field>

                    <b-field label="First Name" :label-position="labelPosition">
                        <b-input v-model="item.first_name"
                                 name="register-first_name" dusk="register-first_name"
                        ></b-input>
                    </b-field>

                    <b-field v-if="!isHidden('middle_name')"
                             label="Middle Name" :label-position="labelPosition">
                        <b-input v-model="item.middle_name"
                                 name="register-middle_name" dusk="register-middle_name"
                        ></b-input>
                    </b-field>

                    <b-field v-if="!isHidden('last_name')"
                             label="Last Name" :label-position="labelPosition">
                        <b-input v-model="item.last_name"
                                 name="register-last_name" dusk="register-last_name"
                        ></b-input>
                    </b-field>

                    <b-field v-if="!isHidden('gender')"
                             label="Gender" :label-position="labelPosition">
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

                    <b-field v-if="!isHidden('country_calling_code')"
                             label="Country Code" :label-position="labelPosition">
                        <b-select placeholder="Select a country code"
                                  name="register-country_code" dusk="register-country_code"
                                  v-model="item.country_calling_code">
                            <option v-for="code in page.assets.country_calling_code"
                                    :value="code.calling_code"
                            >{{code.calling_code}}</option>
                        </b-select>
                    </b-field>

                    <b-field v-if="!isHidden('phone')"
                             label="Phone" :label-position="labelPosition">
                        <b-input v-model="item.phone"
                                 name="register-phone" dusk="register-phone"
                        ></b-input>
                    </b-field>

                    <b-field v-if="!isHidden('bio')"
                             label="Bio" :label-position="labelPosition">
                        <b-input maxlength="250"
                                 v-model="item.bio"
                                 name="register-bio" dusk="register-bio"
                                 type="textarea"></b-input>
                    </b-field>

                    <b-field v-if="!isHidden('timezone')"
                             label="Timezone" :label-position="labelPosition">
                        <AutoCompleteTimeZone
                            :selected_value="item.timezone"
                            :options="page.assets.timezones"
                            :open_on_focus="true"
                            @onSelect="setTimeZone"
                        >
                        </AutoCompleteTimeZone>
                    </b-field>

                    <b-field v-if="!isHidden('alternate_email')"
                             label="Alternate Email" :label-position="labelPosition">
                        <b-input type="email" v-model="item.alternate_email"
                                 name="register-alternate_email" dusk="register-alternate_email"
                        ></b-input>
                    </b-field>

                    <b-field v-if="!isHidden('birth')"
                             label="Date of Birth"
                             :label-position="labelPosition">
                        <DatePicker :selected_value="item.birth"
                                    @onSelect="setBirthDate">
                        </DatePicker>
                    </b-field>

                    <b-field v-if="!isHidden('country')"
                             label="Country" :label-position="labelPosition">
                        <AutoCompleteCountry
                            :selected_value="item.country"
                            :options="page.assets.countries"
                            :open_on_focus="true"
                            @onSelect="setCountry">
                        </AutoCompleteCountry>
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

                    <template v-if="page.assets.custom_fields"
                              v-for="(custom_field) in page.assets.custom_fields.value">

                        <b-field v-if="!custom_field.is_hidden && custom_field.to_registration"
                                 :label="$vaah.toLabel(custom_field.name)" :label-position="labelPosition">
                            <b-input v-model="item.meta[custom_field.name]"
                                     :type="custom_field.type"
                                     :min="custom_field.min"
                                     :max="custom_field.max"
                                     :minlength="custom_field.minlength"
                                     :maxlength="custom_field.maxlength"
                                     :password-reveal="custom_field.is_password_reveal"
                                     :name="'register-meta_'+custom_field.name"
                                     :dusk="'register-meta_'+custom_field.name"
                            ></b-input>
                        </b-field>
                    </template>


                </div>
            </div>
            <!--/content-->





        </div>




    </div>
</template>


