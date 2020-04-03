<script src="./CreateJs.js"></script>
<template>
    <div class="column" v-if="page.assets">

        <div class="card">

            <!--header-->
            <header class="card-header">

                <div class="card-header-title">
                    Create
                </div>


                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button icon-left="edit"
                                      type="is-light"
                                      :loading="is_btn_loading"
                                      @click="create('save')">
                                Save
                            </b-button>
                        </p>

                        <p class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button is-light" slot="trigger">
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

                                <b-dropdown-item aria-role="listitem"
                                                 @click="resetNewItem()">
                                    <b-icon icon="eraser"></b-icon>
                                    Reset
                                </b-dropdown-item>

                            </b-dropdown>


                        </p>

                        <p class="control">
                            <b-button tag="router-link"
                                      type="is-light"
                                      :to="{name: 'reg.list'}"
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
                                 v-model="new_item.email"></b-input>
                    </b-field>


                    <b-field label="Username" :label-position="labelPosition">
                        <b-input v-model="new_item.username"  name="register-username"
                                 dusk="register-username" ></b-input>
                    </b-field>

                    <b-field label="Password" :label-position="labelPosition">
                        <b-input type="password" v-model="new_item.password"
                                 name="register-password" dusk="register-password" ></b-input>
                    </b-field>

                    <b-field label="Display Name" :label-position="labelPosition">
                        <b-input v-model="new_item.display_name"
                                 name="register-display_name" dusk="register-display_name" >
                        </b-input>
                    </b-field>

                    <b-field label="Title" :label-position="labelPosition">
                        <b-select placeholder="- Select a title -"
                                  name="register-title" dusk="register-title"
                                  v-model="new_item.title">
                            <option value="">- Select a title -</option>
                            <option v-for="title in page.assets.name_titles"
                                    :value="title.slug"
                            >{{title.name}}</option>
                        </b-select>
                    </b-field>



                    <b-field label="First Name" :label-position="labelPosition">
                        <b-input v-model="new_item.first_name"
                                 name="register-first_name" dusk="register-first_name"
                        ></b-input>
                    </b-field>

                    <b-field label="Middle Name" :label-position="labelPosition">
                        <b-input v-model="new_item.middle_name"
                                 name="register-middle_name" dusk="register-middle_name"
                        ></b-input>
                    </b-field>

                    <b-field label="Last Name" :label-position="labelPosition">
                        <b-input v-model="new_item.last_name"
                                 name="register-last_name" dusk="register-last_name"
                        ></b-input>
                    </b-field>

                    <b-field label="Gender" :label-position="labelPosition">
                        <b-radio-button v-model="new_item.gender"
                                        name="register-gender" dusk="register-gender"
                                        native-value="m">
                            <b-icon icon="mars"></b-icon>
                            <span>Male</span>
                        </b-radio-button>

                        <b-radio-button v-model="new_item.gender"
                                        name="register-gender" dusk="register-gender"
                                        native-value="f">
                            <b-icon icon="venus"></b-icon>
                            <span>Female</span>
                        </b-radio-button>

                        <b-radio-button v-model="new_item.gender"
                                        name="register-gender" dusk="register-gender"
                                        native-value="o">
                            <b-icon icon="transgender-alt"></b-icon>
                            <span>Other</span>
                        </b-radio-button>


                    </b-field>

                    <b-field label="Country Code" :label-position="labelPosition">
                        <b-select placeholder="- Select a country code -"
                                  name="register-country_code" dusk="register-country_code"
                                  v-model="new_item.country_calling_code">
                            <option value="">- Select a country code -</option>
                            <option v-for="code in page.assets.country_calling_code"
                                    :value="code.calling_code"
                            >{{code.calling_code}}</option>
                        </b-select>
                    </b-field>

                    <b-field label="Phone" :label-position="labelPosition">
                        <b-input v-model="new_item.phone"
                                 name="register-phone" dusk="register-phone"
                        ></b-input>
                    </b-field>

                    <b-field label="Timezone" :label-position="labelPosition">
                        <AutoCompleteTimeZone
                            :options="page.assets.timezones"
                            :open_on_focus="true"
                            @onSelect="setTimeZone"
                        />
                    </b-field>

                    <b-field label="Alternate Email" :label-position="labelPosition">
                        <b-input type="email" v-model="new_item.alternate_email"
                                 name="register-alternate_email" dusk="register-alternate_email"
                        ></b-input>
                    </b-field>

                    <b-field label="Date of Birth" :label-position="labelPosition">
                        <DatePicker @onSelect="setBirthDate"/>
                    </b-field>

                    <b-field label="Country" :label-position="labelPosition">
                        <AutoCompleteCountry
                            :options="page.assets.countries"
                            :open_on_focus="true"
                            @onSelect="setCountry"
                        />
                    </b-field>

                    <b-field label="Status" :label-position="labelPosition">
                        <b-select placeholder="- Select a status -"
                                  name="register-status" dusk="register-status"
                                  v-model="new_item.status">
                            <option value="">- Select a status -</option>
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


