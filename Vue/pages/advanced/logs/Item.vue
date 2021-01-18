<script src="./ItemJs.js"></script>
<template>
    <!--right-->
    <div class="column is-7">

        <!--card-->
        <div class="card" >

            <!--header-->
            <header class="card-header">

                <div class="card-header-title">
                    Log

                    <span v-if="item">
                       :  {{item.name}}
                    </span>

                </div>

                <div class="card-header-title" style="flex-grow: inherit">
                    <b-tooltip label="Download" type="is-dark">
                        <b-button size="is-small"
                                  @click="downloadFile(item.name)"
                                  icon-left="download">
                        </b-button>
                    </b-tooltip>
                </div>

            </header>
            <!--/header-->

            <!--content-->
            <div class="card-content is-paddingless">

                <div v-if="!item">
                    <Loader/>
                </div>

                <div v-else>

                    <b-tabs >
                        <b-tab-item label="Logs">


                            <table class="table">

                                <tr v-for="log in item.logs">
                                    <td>

                                        <div class="level is-marginless">

                                            <div class="level-left">

                                                <div class="level-item">
                                                    <b-taglist attached>
                                                        <b-tag type="is-dark">TYPE</b-tag>
                                                        <b-tag type="is-danger">{{log.type}}</b-tag>
                                                    </b-taglist>
                                                </div>

                                                <div class="level-item">
                                                    <b-taglist attached>
                                                        <b-tag type="is-dark">TIME</b-tag>
                                                        <b-tag type="is-info">
                                                            {{log.timestamp}}
                                                            / {{log.ago}}
                                                        </b-tag>
                                                    </b-taglist>
                                                </div>

                                                <div class="level-item">
                                                    <b-taglist attached>
                                                        <b-tag type="is-dark">ENV</b-tag>
                                                        <b-tag type="is-info">{{log.env}}</b-tag>
                                                    </b-taglist>
                                                </div>

                                            </div>

                                        </div>

                                        <small>
                                            {{log.message}}
                                        </small>
                                    </td>
                                </tr>

                            </table>

                        </b-tab-item>

                        <b-tab-item label="Raw">
                            <small
                                style="max-height: 768px; overflow: auto;"
                                v-html="item.content"></small>
                        </b-tab-item>

                    </b-tabs>

                </div>







            </div>
            <!--/content-->

        </div>
        <!--/card-->


    </div>
    <!--/right-->
</template>


