<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {computed, onMounted, ref, watch} from "vue";
import { useMediaStore } from '../../stores/store-media'
import {useRoute} from 'vue-router';
import { vaah } from "../../vaahvue/pinia/vaah";
import { useRootStore } from '../../stores/root';
import FileUploader from "./components/FileUploader.vue";
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
const root = useRootStore();
const store = useMediaStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {
    if(route.params && route.params.id)
    {
        await store.getItem(route.params.id);
    }
    if (root.assets && root.assets.language_strings
        && root.assets.language_strings.crud_actions)
    {
        await store.getFormMenu();
    }});

//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

/**
 * M6-T1 — the public download link, read-only. The payload already carries
 * the server-computed link (`download_url_full`, the same value the item
 * view opens); the asset base URL plus the media's own slug is the
 * fallback for a payload without it. Both are read defensively because the
 * panel can render before the assets payload has landed.
 */
const full_download_url = computed(() => {
    if (store.item && store.item.download_url_full) {
        return store.item.download_url_full;
    }
    const base = (store.assets && store.assets.download_url) ? store.assets.download_url : '';
    const slug = (store.item && store.item.download_url) ? store.item.download_url : '';
    return base + slug;
});

/**
 * M6-T1 — the upload limit the admin configured, in MB, for the error
 * banner (the message used to name a hard-coded 5 MB).
 */
const max_file_size_label = computed(() => {
    const bytes = (store.assets && store.assets.max_file_size) ? store.assets.max_file_size : 5000000;
    return (bytes / 1024 / 1024).toFixed(2).replace(/\.00$/, '');
});

/**
 * M6-T1 — a thumbnail whose source cannot be loaded is hidden rather than
 * left as a broken glyph (the browser paints the alt text of a failed image
 * inside the image box, and that text is not clipped by the box — it spilled
 * over the file name and the actions beside it).
 */
const hideBrokenImage = (event) => {
    event.target.style.display = 'none';
};

watch(
    () => root.assets,
    async () => {
        // M6-T1 — the watcher fires for every change of the root assets,
        // including the one that leaves them empty; reading
        // `root.assets.language_strings` then threw a TypeError.
        if ( root.assets && root.assets.language_strings && root.assets.language_strings.crud_actions)
        {
            await store.getFormMenu();
        }

    }
)
</script>
<template>
    <div class="col-6">
        <Panel class="vc-dense">
            <Message severity="error"
                     class="p-container-message"
                     :closable="false"
                     icon="pi pi-trash"
                     v-if="store.item && store.item.deleted_at"
            >
                <div class="flex align-items-center justify-content-between"  v-if="root.assets
                           && root.assets.language_strings
                           && root.assets.language_strings.crud_actions">
                    <div>
                        {{root.assets.language_strings.crud_actions.form_text_deleted}} {{store.item.deleted_at}}
                    </div>

                    <div>
                        <Button size="small" :label="root.assets.language_strings.crud_actions.toolkit_text_restore" class="" @click="store.itemAction('restore')" data-testid="media-form_item_action_restore">
                        </Button>
                    </div>
                </div>
            </Message>
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <!-- M6-T1 — the header was `font-semibold text-sm`
                         (12.25px, off the type scale). The item view's panel
                         header uses the engine's `p-panel-title`, so the form
                         header uses the same one now — the two panels read as
                         one surface. -->
                    <div class="p-panel-title">
                        <span v-if="store.item && store.item.id">
                            {{ store.item.name }}
                        </span>
                        <span v-else-if="root.assets
                                         && root.assets.language_strings
                                         && root.assets.language_strings.crud_actions"
                        >
                            {{root.assets.language_strings.crud_actions.form_text_create}}
                        </span>
                    </div>
                </div>
            </template>
            <template #icons>
                <InputGroup v-if="root.assets && root.assets.language_strings && root.assets.language_strings.crud_actions">
                    <Button size="small" v-if="store.item && store.item.id" class="" :label=" '#' + store.item.id " data-testid="media-id" @click="useVaah.copy(store.item.id)" />

                    <Button size="small" :label="root.assets.language_strings.crud_actions.save_button" v-if="store.item && store.item.id" data-testid="media-save" @click="store.itemAction('save')" icon="pi pi-save" class="" />

                    <Button size="small" :label="root.assets.language_strings.crud_actions.form_create_and_new" v-else @click="store.itemAction('create-and-new')" data-testid="media-create-and-new" icon="pi pi-save" class="" />

                    <!--form_menu-->
                    <Button size="small" v-if="store.hasPermission('can-manage-media') || store.hasPermission('can-update-media')" class="" icon="pi pi-angle-down" aria-label="Show actions menu" type="button" data="media-form-menu" aria-haspopup="true" @click="toggleFormMenu" />

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true"
                    />
                    <!--/form_menu-->

                    <Button size="small" class="" v-if="store.item && store.item.id" icon="pi pi-eye" aria-label="View" data-testid="media-to-view" @click="store.toView(store.item)" />

                    <Button size="small" class="" icon="pi pi-times" aria-label="Back to list" data-testid="media-to-list" @click="store.toList()" />
                </InputGroup>
            </template>

            <div v-if="store.item" class="form mt-3">

                <VhField label="Name">
                    <InputText class="w-full" v-model="store.item.name" data-testid="media_name" />
                </VhField>


                    <div class="field mb-4 relative">
                        <FileUploader placeholder="Upload Avatar"
                                      :is_basic="false"
                                      data-testid="media-form_upload_file"
                                      :auto_upload="true"
                                      :file_type_accept="store.assets ? store.assets.allowed_file_types : null"
                                      :max_file_size="store.assets ? store.assets.max_file_size : 5000000"
                                      :uploadUrl="store.ajax_url + '/upload'" >
                        </FileUploader>
                    </div>

                    <!-- M6-T1 — the linked-file block was hand-written v3
                         markup: `p-message p-component p-message-error` with a
                         `p-message-wrapper` (the v3 class — v4's is
                         `p-message-content-wrapper`, so the message rendered
                         with no layout at all) and a `p-fileupload-file-details`
                         block (v4's is `p-fileupload-file-info`). The DOM now
                         matches what the OpenVue Message / FileUpload render,
                         and the remove control is the OpenVue Button.

                         It stays raw markup on purpose: the media area
                         carries exactly two `<Message>` components (F20
                         acceptance step 4), so the banner is not a third
                         one. -->
                    <div v-if="store.has_error_on_upload || store.item.url" class="field mb-4">
                        <div class="p-fileupload-content">
                            <div v-if="store.has_error_on_upload" class="p-message p-message-error"
                                 role="alert" aria-live="assertive"
                                 aria-atomic="true">
                                <div class="p-message-content-wrapper">
                                    <div class="p-message-content">
                                        <span class="p-message-icon pi pi-times-circle"></span>
                                        <div class="p-message-text">
                                            The file could not be uploaded.
                                            It must be smaller than {{ max_file_size_label }} MB.
                                        </div>
                                        <button class="p-message-close-button"
                                                @click="store.has_error_on_upload = false"
                                                aria-label="Close"
                                                type="button">
                                            <i class="p-message-close-icon pi pi-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="store.item.url" class="p-fileupload-file">
                                <!-- M6-T1 — the thumbnail is decorative: the
                                     file name sits beside it in the very
                                     next block. A failed load used to paint
                                     the alt text inside the image box, and
                                     that text is not clipped by the box — it
                                     spilled over the name and the actions.
                                     The image is hidden on a failed load and
                                     the local file icon shows through; a
                                     file that is not an image has no
                                     thumbnail at all — the icon is the
                                     thumbnail. (It used to be a picture
                                     fetched from a third-party icon host,
                                     which no admin's browser can be
                                     expected to reach.) -->
                                <span class="media-file-thumb-frame mr-2">
                                    <i class="pi pi-file media-thumb-fallback"
                                       aria-hidden="true"></i>
                                    <img v-if="store.item.type === 'image' && store.item.url"
                                         role="presentation"
                                         alt=""
                                         class="p-fileupload-file-thumbnail media-file-thumb"
                                         :src="store.item.url"
                                         @error="hideBrokenImage"
                                         width="50">
                                </span>
                                <div class="p-fileupload-file-info">
                                    <div class="p-fileupload-file-name media-file-name">{{ store.item.name }}</div>
                                    <span v-if="store.item.size_for_humans"
                                          class="p-fileupload-file-size media-file-size">
                                        {{ store.item.size_for_humans }}
                                    </span>
                                </div>
                                <div class="p-fileupload-file-actions">
                                    <Button icon="pi pi-times"
                                            severity="danger"
                                            text
                                            rounded
                                            aria-label="Remove linked file"
                                            @click="store.item.url = null"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                <VhField label="Title">
                    <InputText class="w-full"  v-model="store.item.title" data-testid="media_title" />
                </VhField>

                <VhField label="Alternate Text">
                    <InputText class="w-full"  v-model="store.item.alt_text" data-testid="media_alternate_text" />
                </VhField>

                <!-- M6-T1 — the form carried the *same* "Caption" field twice,
                     both bound to `store.item.caption` (a copy-paste duplicate:
                     the alternate-text field above is the one that was meant to
                     be different). One field, one binding. -->
                <VhField label="Caption">
                    <InputText class="w-full"  v-model="store.item.caption" data-testid="media_caption" />
                </VhField>

                <!-- M6-T1 — the label was " Is this a downloadable media?"
                     (with a stray leading space): a question in a field
                     label, and long enough to wrap onto three lines in the
                     half-width panel. It states what the field is. -->
                <VhField label="Downloadable">
                    <SelectButton
                        v-model="store.item.is_downloadable"
                        :options="store.download_options"
                        option-value="value"
                        option-label="label"
                    />
                </VhField>

                <VhField label="Download Url" v-if="store.item.is_downloadable">


                    <InputGroup class="flex-1">
                        <Button size="small" data-testid="media-copy_download_url" @click="store.copyDownloadUrl()" icon="pi pi-copy" aria-label="Copy download link" v-tooltip.top=" 'Copy Download Link' " class="" :disabled="!store.item.download_url" />
                        <InputText size="small" class="w-full border-noround" v-model="store.item.download_url" data-testid="media_download_url" />
                        <Button size="small" v-if="store.downloadable_slug_available" data-testid="media-list-check_url_availability_available" @click="store.isDownloadableSlugAvailable" severity="success" icon="pi pi-check" aria-label="Check URL availability" v-tooltip.top=" 'Download URL Available' " />

                        <Button size="small" v-else data-testid="media-list-check_url_availability" @click="store.isDownloadableSlugAvailable" icon="pi pi-question" aria-label="Check URL availability" :disabled="!store.item.download_url" class="" v-tooltip.top=" 'Check Availability' " />
                    </InputGroup>
                </VhField>


                <!-- M6-T1 — the v3 form ended with a `p-float-label` *pair*:
                     one span holding a second, editable "Download Url" input
                     (a duplicate of the InputGroup field above, bound to the
                     same model) and one span holding the full public link.
                     The F11 conversion turned both into `<FloatLabel>` and
                     dropped their `v-if` conditions, which left a
                     `<FloatLabel>` nested inside a `<FloatLabel>` and read
                     `store.assets.download_url` unconditionally.

                     The pair is now what it was meant to be: the visible
                     input is the InputGroup field above, and the second
                     half is the read-only preview of the full link, shown
                     only when the media is downloadable and has a slug.

                     It is a `VhField` like every other field of this form —
                     a `FloatLabel` floated its label over the row above
                     (the InputGroup) and the label overlapped it. -->
                <VhField label="Download Url (full link)"
                         v-if="store.item.is_downloadable && store.item.download_url">
                    <InputText id="download_url_full" class="w-full" :model-value="full_download_url" readonly />
                </VhField>
                </div>

        </Panel>
    </div>
</template>

<style scoped>
/* M6-T1 — the media form lives in a *half-width* panel (the list keeps
   the other half), so the shared `VhField` label column — a `md:col-2`
   of the panel — collapsed to 95px and every label wrapped onto two or
   three lines ("Is this a downloadable media?" took three). The label
   column is widened for this panel only; the shared field component and
   every other form keep their own geometry. */
:deep(.field.grid > .md\:col-2) {
    width: 30%;
}

:deep(.field.grid > .md\:col-10) {
    width: 70%;
}

/* M6-T1 — the engine only keeps the thumbnail from shrinking
   (`.p-fileupload-file-thumbnail { flex-shrink: 0 }`); a file whose
   image cannot be loaded then rendered its alt text at full width and
   pushed the file name out of the row. The thumbnail is a 50px square. */
.media-file-thumb {
    position: relative;
    display: block;
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}

/* M6-T1 — the thumbnail's frame: a fixed 50px square that clips its
   content, with the local file glyph painted under the image so a
   failed load leaves the glyph instead of a broken one. */
.media-file-thumb-frame {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    flex-shrink: 0;
    overflow: hidden;
    border-radius: 4px;
    background: var(--p-content-hover-background);
}

.media-file-thumb-frame .media-thumb-fallback {
    position: absolute;
    font-size: 16px;
    color: var(--p-text-muted-color);
}

/* M6-T1 — the file name and its size are rendered by *this* template
   (the linked-file block is hand-written markup that mirrors the v4
   FileUpload DOM), so their type size is this task's to set. The engine
   leaves them at the inherited 0.875rem (12.25px at the 14px root);
   the scale puts supporting copy at 13px. */
.media-file-name {
    font-size: 13px;
    line-height: 1.4;
}

.media-file-size {
    font-size: 13px;
    line-height: 1.4;
}
</style>
