<script src="./IndexJs.js"></script>
<template>

    <!--sections-->
    <section class="section" v-if="profile">
        <div class="container">

            <!--repeatable-->
            <div class="columns">
                <div class="column is-8 is-offset-2 " >
                    <h1 class="title is-3">Profile</h1>
                </div>
            </div>
            <!--/repeatable-->


            <!--repeatable-->

            <div class="columns">
                <div class="column is-8 is-offset-2 " >
                    <hr/>
                </div>
            </div>

            <div class="columns">
                <div class="column is-3 is-offset-2" >
                    <h4 class="title is-5">Public Avatar</h4>
                    <h2 class="subtitle is-6">You can upload your avatar here or change it at
                        <a href="https://en.gravatar.com/" target="_blank">gravatar.com</a></h2>
                </div>
                <div class="column is-5 " >

                    <div class="card">
                        <div class="card-content">

                            <article class="media">
                                <figure class="media-left" v-if="profile.avatar">
                                    <p class="image is-64x64">
                                        <img class="is-rounded"
                                             :src="profile.avatar">
                                    </p>
                                </figure>
                                <div class="media-content">

                                    <b-field class="has-margin-bottom-5">
                                        <b-upload drag-drop>
                                            <section class="section">
                                                <div class="content has-text-centered">
                                                    <p class="is-bottom-marginless">
                                                        <b-icon icon="upload"
                                                            size="is-small">
                                                        </b-icon>
                                                    </p>
                                                    <p>Drop your files here or click to upload.</p>
                                                </div>
                                            </section>
                                        </b-upload>

                                    </b-field>
                                    <p class="help">The maximum file size allowed is 200KB.</p>

                                </div>
                            </article>

                        </div>

                    </div>

                </div>
            </div>




            <!--/repeatable-->



            <!--repeatable-->
            <div class="columns">
                <div class="column is-8 is-offset-2 " >
                    <hr/>
                </div>
            </div>

            <div class="columns">
                <div class="column is-3 is-offset-2" >
                    <h4 class="title is-5">Profile Details</h4>
                    <h2 class="subtitle is-6">This information will appear on your profile</h2>
                </div>
                <div class="column is-5 " >

                    <div class="card">
                        <div class="card-content">

                            <div class="block">

                                <b-field label="Email" :label-position="labelPosition">
                                    <b-input type="email"  name="profile-email" dusk="profile-email"
                                             v-model="profile.email"></b-input>
                                </b-field>


                                <b-field label="Username" :label-position="labelPosition">
                                    <b-input v-model="profile.username"  name="profile-username"
                                             dusk="profile-username" ></b-input>
                                </b-field>


                                <b-field label="Display Name"
                                         message="If display name filled, it will be used instead of first name & last name"
                                         :label-position="labelPosition">
                                    <b-input v-model="profile.display_name"
                                             name="profile-display_name" dusk="profile-display_name" >
                                    </b-input>
                                </b-field>

                                <b-field label="Title" :label-position="labelPosition">
                                    <b-select placeholder="Select a title"
                                              name="profile-title" dusk="profile-title"
                                              v-model="profile.title">
                                        <option v-for="title in page.assets.name_titles"
                                                :value="title.slug"
                                        >{{title.name}}</option>
                                    </b-select>
                                </b-field>



                                <b-field label="First Name" :label-position="labelPosition">
                                    <b-input v-model="profile.first_name"
                                             name="profile-first_name" dusk="profile-first_name"
                                    ></b-input>
                                </b-field>

                                <b-field label="Middle Name" :label-position="labelPosition">
                                    <b-input v-model="profile.middle_name"
                                             name="profile-middle_name" dusk="profile-middle_name"
                                    ></b-input>
                                </b-field>

                                <b-field label="Last Name" :label-position="labelPosition">
                                    <b-input v-model="profile.last_name"
                                             name="profile-last_name" dusk="profile-last_name"
                                    ></b-input>
                                </b-field>

                                <b-field label="Gender" :label-position="labelPosition">
                                    <b-radio-button v-model="profile.gender"
                                                    name="profile-gender" dusk="profile-gender"
                                                    native-value="m">
                                        <b-icon icon="mars"></b-icon>
                                        <span>Male</span>
                                    </b-radio-button>

                                    <b-radio-button v-model="profile.gender"
                                                    name="profile-gender" dusk="profile-gender"
                                                    native-value="f">
                                        <b-icon icon="venus"></b-icon>
                                        <span>Female</span>
                                    </b-radio-button>

                                    <b-radio-button v-model="profile.gender"
                                                    name="profile-gender" dusk="profile-gender"
                                                    native-value="o">
                                        <b-icon icon="transgender-alt"></b-icon>
                                        <span>Other</span>
                                    </b-radio-button>


                                </b-field>

                                <b-field label="Country Code" :label-position="labelPosition">
                                    <b-select placeholder="Select a country code"
                                              name="profile-country_code" dusk="profile-country_code"
                                              v-model="profile.country_calling_code">
                                        <option v-for="code in page.assets.country_calling_code"
                                                :value="code.calling_code"
                                        >{{code.calling_code}}</option>
                                    </b-select>
                                </b-field>

                                <b-field label="Phone" :label-position="labelPosition">
                                    <b-input v-model="profile.phone"
                                             name="profile-phone" dusk="profile-phone"
                                    ></b-input>
                                </b-field>

                                <b-field label="Timezone" :label-position="labelPosition">
                                    <AutoCompleteTimeZone
                                        :selected_value="profile.timezone"
                                        :options="page.assets.timezones"
                                        :open_on_focus="true"
                                        @onSelect="setTimeZone"
                                    />
                                </b-field>

                                <b-field label="Alternate Email" :label-position="labelPosition">
                                    <b-input type="email" v-model="profile.alternate_email"
                                             name="profile-alternate_email" dusk="profile-alternate_email"
                                    ></b-input>
                                </b-field>

                                <b-field label="Date of Birth" :label-position="labelPosition">
                                    <DatePicker
                                        :selected_value="profile.birth"
                                        @onSelect="setBirthDate"/>
                                </b-field>

                                <b-field label="Country" :label-position="labelPosition">
                                    <AutoCompleteCountry
                                        :selected_value="profile.country"
                                        :options="page.assets.countries"
                                        :open_on_focus="true"
                                        @onSelect="setCountry"
                                    />
                                </b-field>

                                <b-button type="is-primary" @click="storeProfile()">
                                    Save Profile
                                </b-button>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!--/repeatable-->



            <!--repeatable-->
            <div class="columns">
                <div class="column is-8 is-offset-2 " >
                    <hr/>
                </div>
            </div>

            <div class="columns">
                <div class="column is-3 is-offset-2" >
                    <h4 class="title is-5">Password</h4>
                    <h2 class="subtitle is-6">After a successful password update, you will be redirected to the login page where you can log in with your new password.</h2>
                </div>
                <div class="column is-5">

                    <div class="card">
                        <div class="card-content">

                            <b-field label="Current Password"
                                     message="You must provide your current password in order to change it."
                                     :label-position="labelPosition">
                                <b-input type="password"
                                         name="profile-current_password"
                                         dusk="profile-current_password"
                                         password-reveal
                                         v-model="page.reset_password.current_password"></b-input>
                            </b-field>

                            <b-field label="New Password" :label-position="labelPosition">
                                <b-input type="password"  name="profile-new_password"
                                         dusk="profile-current_password"
                                         password-reveal
                                         v-model="page.reset_password.new_password"></b-input>
                            </b-field>

                            <b-field label="Confirm Password" :label-position="labelPosition">
                                <b-input type="password"  name="profile-confirm_password"
                                         dusk="profile-current_password"
                                         password-reveal
                                         v-model="page.reset_password.confirm_password"></b-input>
                            </b-field>


                            <b-button type="is-primary" @click="storePassword">Save Password</b-button>

                        </div>

                    </div>

                </div>
            </div>
            <!--/repeatable-->


        </div>
    </section>
    <!--sections-->


</template>

