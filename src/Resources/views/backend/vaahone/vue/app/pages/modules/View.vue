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
                    <span>{{$vaah.limitString(item.name, 15)}}</span>
                </div>

                <div class="card-header-buttons">

                    <div class="field has-addons is-pulled-right">
                        <p class="control">
                            <b-button @click="$vaah.copy(item.id)"  type="is-light">
                                <small><b>#{{item.id}}</b></small>
                            </b-button>
                        </p>
                         <p class="control">

                              <b-dropdown aria-role="list" position="is-bottom-left">
                                  <button class="button is-light" slot="trigger">
                                      <b-icon icon="caret-down"></b-icon>
                                  </button>

                                  <b-dropdown-item aria-role="listitem"
                                                   v-if="!item.is_active"
                                                   @click="actions('bulk-activate')"
                                  >
                                      Activate
                                  </b-dropdown-item>

                                  <b-dropdown-item aria-role="listitem"
                                                   v-if="item.is_active"
                                                   @click="actions('bulk-deactivate')"
                                  >
                                      Deactivate
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



                                    <template v-if="label == 'is_active'">
                                        <TableTrStatus :value="value"
                                                       :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'version'">
                                        <TableTrStatus :value="value"
                                                       :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'version_number'">
                                        <TableTrStatus :value="value"
                                                       :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'author_website'">
                                        <TableTrUrl :value="value"
                                                       :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'vaah_url'">
                                        <TableTrUrl :value="value"
                                                    :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'is_migratable'">
                                        <TableTrYesNo :value="value"
                                                       :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'is_sample_data_available'">
                                        <TableTrYesNo :value="value"
                                                      :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'is_update_available'">
                                        <TableTrYesNo :value="value"
                                                      :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'is_assets_published'">
                                        <TableTrYesNo :value="value"
                                                      :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'is_active'">
                                        <TableTrYesNo :value="value"
                                                      :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'created_by'">
                                        <TableTrActedBy :value="item['created_by_user']"
                                                       :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'updated_by'">
                                        <TableTrActedBy :value="item['updated_by_user']"
                                                        :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'deleted_by'">
                                        <TableTrActedBy :value="item['deleted_by_user']"
                                                        :label="label"/>
                                    </template>

                                    <template v-else-if="label == 'created_by_user'
                                      || label == 'updated_by_user' || label == 'deleted_by_user'
                                      || label == 'update_checked_at'"
                                    >

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


