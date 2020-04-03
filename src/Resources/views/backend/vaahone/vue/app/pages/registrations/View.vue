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
                    <span>&nbsp;{{$vaah.limitString(item.name, 25)}}</span>
                </div>

                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button type="is-light"
                                      @click="resetActiveItem()">
                                <small>#{{item.id}}</small>
                            </b-button>
                        </p>
                        <p class="control">
                            <b-button icon-left="edit"
                                      type="is-light"
                                      tag="router-link"
                                      :to="{name:'reg.edit', params:{id: item.id}}">
                                Edit
                            </b-button>
                        </p>

                        <p class="control">


                            <b-dropdown aria-role="list" position="is-bottom-left">
                                <button class="button is-light" slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem"
                                                 v-if="!item.deleted_at"
                                                 @click="actions('bulk-trash')"
                                >
                                    <b-icon icon="trash"></b-icon>
                                    Trash
                                </b-dropdown-item>

                                <b-dropdown-item aria-role="listitem"
                                                 v-if="item.deleted_at"
                                                 @click="actions('bulk-restore')"
                                >
                                    <b-icon icon="trash-restore"></b-icon>
                                    Restore
                                </b-dropdown-item>
                                <b-dropdown-item aria-role="listitem"
                                                 @click="confirmDelete()"
                                >
                                    <b-icon icon="eraser"></b-icon>
                                    Delete
                                </b-dropdown-item>

                            </b-dropdown>


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

                                    <template v-if="label == 'status'">
                                        <TableTrStatus :value="value"
                                                       :label="label"
                                                       :is_copiable="isCopiable(label)"
                                                       :is_upper_case="isUpperCase(label)"/>
                                    </template>
                                    <template v-else>
                                        <TableTrView :value="value"
                                                     :label="label"
                                                     :is_copiable="isCopiable(label)"
                                                     :is_upper_case="isUpperCase(label)"
                                        />
                                    </template>

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


