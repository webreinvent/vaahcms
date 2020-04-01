<script src="./ViewJs.js"></script>
<template>
    <div class="column" v-if="page.assets">

        <div class="block" v-if="is_content_loading">
            <Loader/>
        </div>

        <div class="card" v-else>

            <!--header-->
            <header class="card-header">

                <div class="card-header-title">
                    <span>#{{item.id}} / </span>
                    <span>{{item.name}}</span>
                </div>

                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button icon-left="edit"
                                      :loading="is_btn_loading"
                                      @click="create('save')">
                                Save
                            </b-button>
                        </p>

                        <p class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
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

                        <p class="control">
                            <b-button tag="router-link"
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

                <div class="block" >


                    content

                </div>
            </div>
            <!--/content-->





        </div>




    </div>
</template>


