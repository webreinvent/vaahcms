<script src="./ListSmallViewJs.js"></script>
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

                <b-table-column v-slot="props" field="name" label="Name">
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column v-slot="props" field="mime" label="Mime Type">
                    {{ props.row.mime_type }}
                </b-table-column>

                <b-table-column v-slot="props" field="size" label="Size">
                    {{ props.row.size_for_humans }}
                </b-table-column>

                <b-table-column v-slot="props" field="created_at" label="Uploaded At">
                    {{ $vaah.fromNow(props.row.created_at) }}
                </b-table-column>

                <b-table-column v-slot="props" v-if="hasPermission('can-read-media')"
                                field="actions" label=""
                                width="80">

                    <b-tooltip label="Open" type="is-dark">
                        <b-button size="is-small"
                                  tag="a"
                                  target="_blank"
                                  :href="props.row.url"
                                  icon-left="external-link-alt">
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
