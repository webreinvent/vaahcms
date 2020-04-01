<script src="./ViewJs.js"></script>
<template>
    <div class="column" v-if="page.assets">

        <div class="card" v-if="is_content_loading">
            <Loader/>
        </div>

        <div class="card" v-else-if="item">

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
                                Edit
                            </b-button>
                        </p>

                        <p class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button" slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem">
                                    <b-icon icon="trash-restore"></b-icon>
                                    Restore
                                </b-dropdown-item>
                                <b-dropdown-item aria-role="listitem">
                                    <b-icon icon="eraser"></b-icon>
                                    Delete
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

            <b-notification type="is-danger"
                            :closable="false"
                            class="is-light is-small"
                            v-if="item.deleted_at"
            >
                Deleted {{$vaah.fromNow(item.deleted_at)}}
            </b-notification>

            <!--content-->
            <div class="card-content is-paddingless ">



                <div class="block" >


                    <div class="b-table">

                        <div class="table-wrapper">
                            <table class="table is-hoverable">

                                <tbody>

                                <template v-for="(value, label) in item">

                                    <TableTrView :value="value"
                                                 :label="label"
                                                 :is_copiable="isCopiable(label)"
                                                 :is_upper_case="isUpperCase(label)"
                                    />

                                </template>

                                </tbody>



                            </table>
                        </div>

                    </div>


                </div>
            </div>
            <!--/content-->


        </div>




    </div>
</template>


