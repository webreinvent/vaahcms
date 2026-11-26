<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';
import {vaah} from '../../vaahvue/pinia/vaah';
import { useMediaStore } from '../../stores/store-media';
import { useRootStore } from "../../stores/root";
import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
const root = useRootStore();
const store = useMediaStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {

    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if(route.params && !route.params.id)
    {
        store.toList();
        return false;
    }

    /**
     * Fetch the record from the database
     */
    if(!store.item || Object.keys(store.item).length < 1)
    {
        await store.getItem(route.params.id);
    }

    /**
     * Watch if url record id is changed, if changed
     * then fetch the new records from database
     */
    /*watch(route, async (newVal,oldVal) =>
        {
            if(newVal.params && !newVal.params.id
                && newVal.name === 'articles.view')
            {
                store.toList();

            }
            await store.getItem(route.params.id);
        }, { deep: true }
    )*/

    if(route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

});

//--------toggle item menu
const item_menu_state = ref();
const toggleItemMenu = (event) => {
    item_menu_state.value.toggle(event);
};
//--------/toggle item menu

/**
 * M6-T1 — a thumbnail whose source cannot be loaded is hidden rather than
 * left as a broken glyph. The browser paints the alt text of a failed image
 * *inside* the image box and that text is not clipped by the box, so it
 * spilled over the row. The thumbnail is decorative here (`alt=""`), so
 * there is nothing to read — only the empty frame to show.
 */
const hideBrokenImage = (event) => {
    event.target.style.display = 'none';
};

</script>
<template>

    <div class="col-6" >

        <Panel v-if="store && store.item" class="vc-dense">

            <template class="p-1" #header>

                <div class="flex flex-row">

                    <div class="p-panel-title">
                        {{store.item.name}}
                    </div>

                </div>

            </template>

            <template #icons>


                <InputGroup>
                    <Button size="small" :label=" '#' + store.item.id " class="" @click="useVaah.copy(store.item.id)" data-testid="media-item-id" />

                    <Button size="small" :label="root.assets.language_strings.crud_actions.view_edit" class="" @click="store.toEdit(store.item)" data-testid="media-item-to-edit" icon="pi pi-pencil" v-if="store.hasPermission('can-update-media') && root.assets && root.assets.language_strings && root.assets.language_strings.crud_actions" />

                    <!--item_menu-->
                    <Button size="small" class="" @click="toggleItemMenu" data-testid="media-item-menu" icon="pi pi-angle-down" aria-label="Show actions menu" aria-haspopup="true" v-if="store.hasPermission('can-update-media') || store.hasPermission('can-manage-media')" />

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true"
                    />
                    <!--/item_menu-->

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" data-testid="media-item-to-list" @click="store.toList()" />
                </InputGroup>
            </template>

            <div v-if="store.item">
                <Message severity="error"
                         class="p-container-message"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item.deleted_at"
                >
                    <div class="flex align-items-center justify-content-between" v-if="root.assets
                               && root.assets.language_strings
                               && root.assets.language_strings.crud_actions"
                    >

                        <div class="">
                            {{root.assets.language_strings.crud_actions.view_deleted}} {{store.item.deleted_at}}
                        </div>

                        <div class="">
                            <Button size="small" :label="root.assets.language_strings.crud_actions.view_restore" class="" data-testid="media-item-restore" @click="store.itemAction('restore')" />
                        </div>
                    </div>
                </Message>

                <!-- M6-T1 — the field list is hand-rolled markup (one row per
                     attribute), not the DataTable component. Its classes are
                     v4's now: `p-component` is a v3 class that no longer
                     exists, `p-datatable-sm` is the v4 small density the
                     media list table uses, and the zebra stripe is restored
                     with the app's own content-scheme token (v4's stripe
                     rule targets the `p-row-odd` class the DataTable
                     component adds to its rows, which hand-rolled rows do
                     not carry). -->
                <div class="p-datatable p-datatable-sm media-item-fields">
                    <table class="p-datatable-table">
                        <tbody class="p-datatable-tbody">
                            <template v-for="(value, column) in store.item ">

                                <template v-if="column === 'created_by'
                                || column === 'updated_by'
                                || column === 'size_for_humans'
                                || column === 'thumbnail_size_for_humans'
                                || column === 'download_url_full'">
                                </template>

                                <template v-else-if="column === 'id' || column === 'uuid'">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               :can_copy="true"
                                    />
                                </template>

                                <template v-else-if="(column === 'created_by_user' ||
                                column === 'updated_by_user'  || column === 'deleted_by_user')
                                                    && (typeof value === 'object' && value !== null)">
                                    <VhViewRow :label="column"
                                               :value="value"
                                               type="user"
                                    />
                                </template>

                                <template v-else-if="(column === 'url'
                                    || column === 'url_thumbnail') && store.item.type === 'image'">
                                    <tr>
                                        <td :style="{width: '200px'}">
                                            <b>{{vaah().toLabel(column.replace("url", store.item.type))}}</b>
                                        </td>
                                        <!-- M6-T1 — the thumbnail was a bare
                                             <img> with a width/height pair.
                                             When the image cannot be
                                             loaded the browser paints the
                                             alt text *inside* the box, and
                                             the text is not clipped by the
                                             image box — it spilled over the
                                             row and over the value column.

                                             Two changes: a fixed, clipped
                                             frame holds the thumbnail, and
                                             the thumbnail is *decorative*
                                             (`alt=""`, `role="presentation"`)
                                             so a failed load paints no text
                                             at all. The file name is already
                                             on the "Name" row of this same
                                             table, so nothing is lost. A
                                             failed load is hidden outright
                                             rather than left as a broken
                                             glyph. -->
                                        <td>
                                            <span v-if="store.item[column]"
                                                  class="media-item-thumb"
                                            >
                                                <i class="pi pi-file media-thumb-fallback"
                                                   aria-hidden="true"></i>
                                                <img :src="store.item[column]"
                                                     alt=""
                                                     role="presentation"
                                                     @error="hideBrokenImage"
                                                />
                                            </span>
                                        </td>
                                        <td v-if="store.item[column]">
                                            <Button size="small" icon="pi pi-external-link" aria-label="Open image in a new tab" text @click="store.openImage(store.item[column])"/>
                                        </td>
                                    </tr>

                                </template>

                                <template v-else-if="column === 'is_active' ||
                                column === 'is_downloadable' || column === 'download_requires_login'">
                                    <!-- M6-T1 — these three flags *state* a
                                         condition ("this media is not
                                         downloadable", "this download does
                                         not require a login"). Their "No"
                                         is an answer, not a failure — the
                                         default danger red claimed a
                                         failure that had not happened
                                         (colour is a signal). The shared
                                         renderer takes the severity as a
                                         prop so this screen can state it
                                         neutrally; the other item views
                                         keep the long-standing default.

                                         M6-T1 shipped `secondary` here. The
                                         merge resolution unifies it on
                                         `warn` — the tone the shared
                                         renderer's default now carries
                                         (M6-T5's resolution, and the
                                         contract's own wording: "not
                                         switched on yet" is a caution, not
                                         an error). All seven item views
                                         render the same flag the same way;
                                         `secondary` would have read as
                                         "not applicable" and split media
                                         from its six peers. -->
                                    <VhViewRow :label="column"
                                               :value="value"
                                               type="yes-no"
                                               no_severity="warn"
                                    />
                                </template>

                                <template v-else-if="column === 'size'
                                 || column === 'thumbnail_size'">
                                    <tr>
                                        <td><b>{{ vaah().toLabel(column) }}</b></td>
                                        <td colspan="2">
                                            <!-- M6-T1 — a media without a
                                                 thumbnail has a null size:
                                                 the Tag rendered an empty
                                                 blue pill (a colour that
                                                 signals a value). The
                                                 app's own empty marker is
                                                 used instead.

                                                 The size itself wears the
                                                 engine's default tag tone,
                                                 like the same value in the
                                                 media list table — a byte
                                                 count is not an "informational
                                                 state", so it does not wear
                                                 the info blue. -->
                                            <Tag v-if="store.item[column+'_for_humans']"
                                            >{{ store.item[column+'_for_humans'] }}</Tag>
                                            <span v-else class="vaah-empty-value">—</span>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else-if="column === 'path'">
                                    <tr>
                                        <td><b>{{ vaah().toLabel(column) }}</b></td>
                                        <td style="overflow-wrap: anywhere;">{{ value }}</td>
                                    </tr>
                                </template>

                                <template v-else-if="store.item.type !== 'image'
                                && (column === 'url' ||
                                column === 'url_thumbnail') ">
                                    <tr>
                                        <td><b>{{ vaah().toLabel(column) }}</b></td>
                                        <td style="overflow-wrap: anywhere;">{{ value }}</td>
                                        <td v-if="value">
                                            <Button size="small" icon="pi pi-external-link" aria-label="Open image in a new tab" text @click="store.openImage(value)"/>
                                        </td>
                                    </tr>
                                </template>

                                <template v-else-if="column === 'download_url' ">
                                    <tr>
                                        <td><b>{{ vaah().toLabel(column) }}</b></td>
                                        <td style="overflow-wrap: anywhere;">{{ (store.assets ? store.assets.download_url : '') }}{{ value }}</td>
                                        <td v-if="store.item.download_url_full">
                                            <Button size="small" icon="pi pi-external-link" aria-label="Open image in a new tab" text @click="store.openImage(store.item.download_url_full)"/>
                                        </td>
                                    </tr>
                                </template>

                                <template v-else-if="column === 'meta'">
                                    <tr>
                                        <td><b>Meta</b></td>
                                        <td  v-if="value">
                                            <Button size="small" icon="pi pi-eye" label="View" variant="outlined" severity="secondary" rounded @click="store.openModal(value)" data-testid="register-open_meta_modal" />
                                        </td>
                                    </tr>

                                    <Dialog header="Meta"
                                            v-model:visible="store.display_meta_modal"
                                            :breakpoints="{'960px': '75vw', '640px': '90vw'}"
                                            :style="{width: '50vw'}" :modal="true"
                                    >
                                        <p class="m-0" v-html="'<pre>'+store.meta_content+'<pre>'"></p>
                                    </Dialog>

                                </template>

                                <template v-else>
                                    <VhViewRow :label="column"
                                               :value="value"
                                   />
                                </template>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </Panel>
    </div>
</template>

<style scoped>
/* ── M6-T1 — the zebra stripe of the hand-rolled field list.
   v4's own stripe rule is `.p-datatable-striped .p-datatable-tbody >
   tr.p-row-odd` — `p-row-odd` is a class the DataTable *component* puts on
   its rows, so the rule never reaches a hand-rolled row. The stripe is
   restored here with the engine's own striped-row token — the same one the
   media list table paints its rows with (and the same one the sibling
   hand-rolled list, `pages/modules/Item.vue`, uses), so the two media
   screens are striped in the same shade. */
.media-item-fields .p-datatable-tbody > tr:nth-child(even) {
    background: var(--p-datatable-row-striped-background);
}

/* M6-T1 — the field list's label column is a fixed 150px (the shared
   `VhViewRow` default). On a phone that left the value column ~180px
   wide, so every value wrapped onto three to five lines ("Title of
   sample-image.png" took five). The label column narrows with the
   viewport; the value keeps the rest. */
@media (max-width: 575px) {
    .media-item-fields .p-datatable-tbody > tr > td:first-child {
        width: 40%;
    }
}

/* M6-T1 — the thumbnail frame: a fixed 45px circle that clips its
   content. A broken image paints its alt text inside the image box and
   grows it to fit the text, which spilled the file name across the row. */
.media-item-thumb {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    overflow: hidden;
    border-radius: 50%;
    background: var(--p-content-hover-background);
}

.media-item-thumb img {
    position: relative;
    width: 45px;
    height: 45px;
    object-fit: cover;
}

/* M6-T1 — the local file glyph, painted under the thumbnail so a failed
   image load leaves the glyph instead of an empty circle. */
.media-thumb-fallback {
    position: absolute;
    font-size: 16px;
    color: var(--p-text-muted-color);
}
</style>
