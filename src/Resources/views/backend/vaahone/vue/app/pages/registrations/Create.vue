<script src="./CreateJs.js"></script>
<template>
    <div class="column" v-if="page.assets">

        <!--title-->
        <div class="level">

            <!--left-->
            <div class="level-left">
                <div class="level-item">
                    <h2 class="title  is-bottom-marginless">Create</h2>
                </div>
            </div>
            <!--/left-->


            <!--right-->
            <div class="level-right">
                <div class="level-item">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button icon-left="edit">
                                Save
                            </b-button>
                        </p>

                        <p class="control">


                            <b-dropdown hoverable aria-role="list" position="is-bottom-left">
                                <button class="button" slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem">
                                    <b-icon icon="check"></b-icon>
                                    Save & Close
                                </b-dropdown-item>
                                <b-dropdown-item aria-role="listitem">
                                    <b-icon icon="plus"></b-icon>
                                    Save & New
                                </b-dropdown-item>

                            </b-dropdown>


                        </p>



                    </div>


                </div>

                <div class="level-item">
                    <b-button tag="router-link"
                              :to="{name:'reg.list'}"
                              icon-right="times"
                              >

                    </b-button>
                </div>

            </div>
            <!--/right-->

        </div>
        <!--/title-->



        <div class="block">

            <b-field label="Email" :label-position="labelPosition">
                <b-input v-model="new_item.email"></b-input>
            </b-field>


            <b-field label="Username" :label-position="labelPosition">
                <b-input v-model="new_item.username"></b-input>
            </b-field>

            <b-field label="Password" :label-position="labelPosition">
                <b-input v-model="new_item.password"></b-input>
            </b-field>

            <b-field label="Display Name" :label-position="labelPosition">
                <b-input v-model="new_item.display_name"></b-input>
            </b-field>

            <b-field label="Title" :label-position="labelPosition">
                <b-select placeholder="Select a title">
                    <option value="2">Option 2</option>
                    <option v-for="title in page.assets.name_titles"
                            :value="title.slug"
                    >{{title.name}}</option>
                </b-select>
            </b-field>



            <b-field label="First Name" :label-position="labelPosition">
                <b-input v-model="new_item.first_name"></b-input>
            </b-field>

            <b-field label="Middle Name" :label-position="labelPosition">
                <b-input v-model="new_item.middle_name"></b-input>
            </b-field>

            <b-field label="Last Name" :label-position="labelPosition">
                <b-input v-model="new_item.last_name"></b-input>
            </b-field>

            <b-field label="Gender" :label-position="labelPosition">
                <b-radio-button v-model="new_item.gender"
                                native-value="m">
                    <b-icon icon="mars"></b-icon>
                    <span>Male</span>
                </b-radio-button>

                <b-radio-button v-model="new_item.gender"
                                native-value="f">
                    <b-icon icon="venus"></b-icon>
                    <span>Female</span>
                </b-radio-button>

                <b-radio-button v-model="new_item.gender"
                                native-value="o">
                    <b-icon icon="transgender-alt"></b-icon>
                    <span>Other</span>
                </b-radio-button>


            </b-field>



        </div>


    </div>
</template>


