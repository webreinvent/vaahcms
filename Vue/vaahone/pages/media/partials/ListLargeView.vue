<script src="./ListLargeViewJs.js"></script>
<template>
    <div v-if="page.list">
        <b-table :data="page.list_is_empty ? [] : page.list.data"
                 :checkable="hasPermission('can-update-media') ? true : false"
                 :checked-rows.sync="page.bulk_action.selected_items"
                 checkbox-position="left"
                 :hoverable="true"
                 :row-class="setRowClass">

            <template>


                <b-table-column v-slot="props" field="thumbnail" width="150" label="thumbnail" centered>

                    <figure class="image" v-if="props.row.url_thumbnail">
                        <img style="max-width: 75px; max-height: 42px" :src="props.row.url_thumbnail">
                    </figure>

                    <b-icon v-else
                            icon="file"
                            size="is-medium">
                    </b-icon>

                </b-table-column>

                <b-table-column v-slot="props" field="file" label="File">


                    <div class="b-table">

                        <div class="table-wrapper">
                            <table class="table is-borderless">

                                <tbody>
                                <tr><th width="80">Name</th><td>{{ props.row.name }}</td></tr>
                                <tr v-if="props.row.title"><th width="80">Title</th><td>{{ props.row.title }}</td></tr>
                                <tr><th width="80">Details</th>
                                    <td>
                                        <b-tag>{{ props.row.size_for_humans }}</b-tag>
                                        <b-tag>{{ props.row.mime_type }}</b-tag>
                                    </td>
                                </tr>
                                </tbody>



                            </table>
                        </div>

                    </div>

                </b-table-column>

                <b-table-column v-slot="props" field="updated_at" label="Updated At" sortable  >
                    {{ $vaah.fromNow(props.row.updated_at) }}
                </b-table-column>



                <b-table-column v-slot="props" v-if="hasPermission('can-read-media')"
                                field="actions" label=""
                                width="120">

                    <b-tooltip label="Open" type="is-dark">
                        <b-button size="is-small"
                                  tag="a"
                                  target="_blank"
                                  :href="props.row.url"
                                  icon-left="external-link-alt">
                        </b-button>
                    </b-tooltip>

                    <b-tooltip v-if="hasPermission('can-update-media')"
                               label="Edit" type="is-dark">
                        <b-button size="is-small"
                                  @click="setActiveItem(props.row,'media.edit')"
                                  icon-left="edit">
                        </b-button>
                    </b-tooltip>

                    <b-tooltip label="View" type="is-dark">
                        <b-button size="is-small"
                                  @click="setActiveItem(props.row)"
                                  icon-left="chevron-right">
                        </b-button>
                    </b-tooltip>

                </b-table-column>



            </template>

            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>Nothing here.</p>
                    </div>
                </section>
            </template>

        </b-table>
    </div>
</template>

