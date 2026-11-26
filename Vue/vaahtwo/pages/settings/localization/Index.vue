<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';
import {useLocalizationStore} from '../../../stores/settings/store-localization'
const store = useLocalizationStore();
const route = useRoute();
import { useConfirm } from "openvue/useconfirm";
const confirm = useConfirm();
onMounted(async () => {
    /**
     * call onLoad action when List view loads
     */
    await store.onLoad(route);
    /**
     * fetch assets required for the crud
     * operation
     */
    await store.setPageTitle();
    await store.getAssets();
    store.getItemMenuList()
    /**
     * Change to upper case
     */
});

const item_menu_list = ref();
const toggleItemMenuList = (event) => {
    item_menu_list.value.toggle(event);
};

</script>

<template>
    <Panel class="vc-dense" v-if="store && store.assets">
        <template class="p-1" #header>
            <div class="flex flex-row">
               
            </div>
        </template>

        <template #icons>
            <div class="buttons">
                <Button size="small" icon="pi pi-plus" :label="store.assets.language_strings.add_language_button" data-testid="localization-add_language" @click="store.toggleLanguageForm" class=" mr-2" />

                <Button size="small" icon="pi pi-plus " :label="store.assets.language_strings.add_category_button" data-testid="localization-add_category" @click="store.toggleCategoryForm" class=" mr-2" />

                <Button size="small" class=" mr-2" icon="pi pi-ellipsis-h" aria-label="More options" aria-haspopup="true" aria-controls="item_menu_list" data-testid="localization-item_menu_list" @click="toggleItemMenuList" />

                <Menu ref="item_menu_list"
                      :model="store.item_menu_list"
                      :popup="true"
                />

                <Button size="small" icon="pi pi-refresh" aria-label="Sync translations" data-testid="localization-sync" @click="store.sync()" class="" v-tooltip.top="store.assets.language_strings.localization_toolkit_sync" :loading="store.btn_is_loading" />
            </div>
        </template>
        <!-- UT-113 — the caution was the engine's `Message severity="warn"`,
             which fills the whole box with the Nide preset's literal warn
             fill — a solid yellow slab in light mode. It is now the app's own
             caution band (`.vc-notice-warn`, the third member of the
             info / error family) with the exclamation-triangle glyph as the
             non-colour signal, so it reads as a note *in* the panel rather
             than a slab glued to it. Presentation only; the string, its
             source and the warning's meaning are untouched. -->
        <div class="localization-notice vc-notice vc-notice-warn mt-1"
             data-testid="localization-notice"
        >
            <i class="pi pi-exclamation-triangle vc-notice-icon"
               aria-hidden="true"></i>
            <p class="vc-notice-text"
               v-html="store.assets.language_strings.localization_message"
            ></p>
        </div>

        <div class="flex align-items-center">
            <div class="mb-4" v-if="store.show_add_language">
                <div class="p-1 vaah-type-caption mb-1">{{ store.assets.language_strings.add_new_languages }}</div>

                <div class="level has-padding-bottom-25">
                    <div class="level-left">
                        <div  class="level-item">
                            <InputGroup>
                                <inputText size="small"
                                           aria-label="New language name"
                                           name="localization-language-name"
                                           v-model="store.new_language.name"
                                           data-testid="localization-new_language_name"
                                           :placeholder="store.assets.language_strings.add_new_languages_placeholder_name"
                                />

                                <inputText size="small"
                                           aria-label="New language locale code"
                                           name="localization-language-local-code-iso-639"
                                           data-testid="localization-new_language_code"
                                           v-model="store.new_language.locale_code_iso_639"
                                           :placeholder="store.assets.language_strings.add_new_languages_placeholder_locale_code"
                                />

                                <Button size="small" @click="store.storeLanguage" icon="pi pi-plus" data-testid="localization-new_language_save" :label="store.assets.language_strings.add_new_languages_save_button" class="" />
                            </InputGroup>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4" v-if="store.show_add_category">
                <div class="p-1 vaah-type-caption mb-1">{{ store.assets.language_strings.add_new_category }}</div>

                <div class="level has-padding-bottom-25" >

                    <!--left-->
                    <div class="level-left">
                        <div  class="level-item">
                            <InputGroup>
                                <inputText size="small"
                                           aria-label="New category name"
                                           v-model="store.new_category.name"
                                           data-testid="localization-new_category_name"
                                           :placeholder="store.assets.language_strings.add_new_category_placeholder_category_name"
                                />

                                <Button size="small" @click="store.storeCategory" icon="pi pi-plus" data-testid="localization-new_category_save" :label="store.assets.language_strings.add_new_category_save_button" class="" />
                            </InputGroup>
                        </div>
                    </div>
                    <!--/left-->
                    <!--right-->
                    <!--/right-->
                </div>
            </div>
        </div>

        <div class="grid justify-content-between vaah-filter-bar mt-3">
            <div class="col-4 align-items-center flex">
                <!-- UT-108 — the language filter is a peer of the toolbar
                     cluster beside it (same filter band, same control
                     height). Left at the engine's `p-select-sm` default
                     (2rem = 28px) it read as a visibly smaller control in
                     the same row as the 36px cluster, so it is brought onto
                     the density contract's 36px control height. -->
                <Select aria-label="Filter by language" v-model="store.query_string.lang_id" :options="store.languages" :data-testid="'localization-language_filter'" optionLabel="option_label" optionValue="id" @change="store.getList()" :placeholder="store.assets.language_strings.localization_placeholder_select_a_language" inputClass="" class="vc-dense localization-language-filter" />
            </div>

            <div class="col">
                <!-- UT-108 (D3, updated) — the search field, the magnifier, the two
                     filter selects and "Reset" are now grouped into ONE connected
                     InputGroup — the same single flush unit the Textarea rows below
                     use — instead of four loose controls scattered on the row. The
                     search field grows to fill the room (localization-toolbar-field);
                     the two filters and "Reset" keep their intrinsic width
                     (localization-toolbar-filter / -action). The whole filter row
                     carries a top margin for breathing room (mt-3 above). -->
                <InputGroup class="localization-toolbar w-full items-center">
                    <InputText aria-label="Search translations" class="localization-toolbar-field" v-model="store.query_string.q" @keyup.enter="store.delayedSearch()" @keyup.enter.native="store.delayedSearch()" @input="store.delayedSearch()" :placeholder="store.assets.language_strings.localization_placeholder_search" data-testid="role-action_search_input" />

                    <Button icon="pi pi-search" aria-label="Search" data-testid="user-action_search" @click="store.delayedSearch()" />

                    <Select class="localization-toolbar-filter" aria-label="Filter by category" v-model="store.query_string.cat_id" :data-testid="'localization-category_filter'" :options="store.categories" optionLabel="name" optionValue="id" @change="store.getList()" :placeholder="store.assets.language_strings.localization_placeholder_select_a_category" inputClass="" />

                    <Select class="localization-toolbar-filter" aria-label="Filter by value" v-model="store.query_string.filter" :options="[ {name:store.assets.language_strings.localization_empty_value, value:'empty'}, {name:store.assets.language_strings.localization_filled_value, value:'filled'} ]" @change="store.getList()" :data-testid="'localization-more_filter'" optionLabel="name" optionValue="value" :placeholder="store.assets.language_strings.localization_placeholder_select_a_filter" inputClass="" />

                    <Button class="localization-toolbar-action" :label="store.assets.language_strings.localization_reset_button" icon="pi pi-filter-slash" @click="store.removeQueryString" data-testid="localization-reset" />
                </InputGroup>
            </div>
        </div>

        <div class="grid mt-1">
            <div v-if="store.list" class="col-12 md:col-6" v-for="(item,index) in store.list.data">
                <div class="p-1 vaah-type-caption mb-1 font-bold">{{item.slug}}</div>

                <InputGroup>
                        <Textarea v-model="item.content"
                                  :aria-label="'Translation for ' + item.slug"
                                  rows="1"
                                  :data-testid="'localization-'+item.slug"
                                  class="w-full localization-string-field"
                        />

                    <Button icon="pi pi-copy" aria-label="Copy to clipboard"
                            :disabled="!item.id"
                            data-testid="localization-copyString"
                            @click="store.getCopy(item)"
                    />

                    <Button size="small" icon="pi pi-trash" aria-label="Delete translation" data-testid="localization-deleteString" @click="store.deleteString(item)" class="p-button-danger" />
                </InputGroup>
            </div>

            <div v-else>
                {{ store.assets.language_strings.no_language_string_exist }}
            </div>
        </div>

        <Paginator v-if="store.list"
                   v-model:rows="store.filters.rows"
                   :totalRecords="store.list.total"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   class="bg-white-alpha-0"
        />

        <div class="grid justify-content-start mt-1">
            <div class="col-12">
                <InputGroup>
                    <InputText size="small" class="" aria-label="New translation string" v-model="store.new_variable" data-testid="localization-add_string" />

                    <Button size="small" :label="store.assets.language_strings.localization_add_string_button" icon="pi pi-plus" @click="store.addVariable" :disabled="!store.new_variable" class="" />
                </InputGroup>
            </div>

            <div class="col-12">
                <InputGroup class="justify-content-end">
                    <Button size="small" :label="store.assets.language_strings.localization_generate_language_files" data-testid="localization-generate_languafe_file" icon="pi pi-refresh" @click="store.generateLanguage" class="" />

                    <Button size="small" :label="store.assets.language_strings.localization_save_button" data-testid="localization-save" icon="pi pi-save" @click="store.storeData" class="" />
                </InputGroup>
            </div>
        </div>
    </Panel>
</template>

<style scoped>

/* UT-108 (D3) — the search field and the two filter selects are EQUAL-width
   peers: all three share `flex: 1 1 0` (zero basis, equal grow/shrink) so they
   split the available room evenly and render at the same width. A common
   min-width floor keeps them equal even while shrinking before the row wraps.
   The magnifier and "Reset" are the fixed ends (below). */
.localization-toolbar-field {
    flex: 1 1 0;
    min-width: 11rem;
}

/* The engine's InputGroup is flex-wrap: nowrap, so once all five controls are
   inside one group the row cannot wrap — the right-most controls get clipped
   off the edge on any screen where they don't all fit. Restoring wrap (this
   rule is unlayered, so it beats the engine's nowrap) so the group drops the
   filters onto their own line instead of hiding them. */
.localization-toolbar {
    flex-wrap: wrap;
}

/* Each filter select matches the search field (same `flex: 1 1 0` + same
   min-width) so all three render at an equal width. The min-width also stops
   the engine's `width: 1%` select label from collapsing a Select narrower
   than its placeholder text while the row wraps. */
.localization-toolbar-filter {
    flex: 1 1 0;
    min-width: 11rem;
}

.localization-toolbar-action {
    flex: 0 0 auto;
}

/* UT-108 — one uniform line for every control in this row. All controls are
   the density contract's 36px (2.5714rem at the 14px root): the Selects are
   pinned to it here (the search field and the buttons already get it from
   the F09 density rules), and the text of every control carries ONE line box
   equal to the control height. That removes the extra inherited line height
   that left the labels floating too high in their controls, so the row's
   text — language / category / filter labels, the search text, the button
   labels — all sit on the same line. :deep() reaches the engine-rendered
   inner elements (the select label spans, the button label span), which the
   scoped attribute never lands on. */
.localization-language-filter,
.localization-toolbar-filter,
.localization-toolbar :deep(.p-inputtext),
.localization-toolbar :deep(.p-button) {
    height: 2.5714rem;
}

.localization-language-filter :deep(.p-select-label),
.localization-toolbar-filter :deep(.p-select-label),
.localization-toolbar :deep(.p-inputtext),
.localization-toolbar :deep(.p-button-label) {
    line-height: 1.5714rem;
}

/* The Nide preset (the engine's base theme, emitted in `@layer openvue`)
   floors every `.p-textarea` at `min-height: 4rem` (56px at the 14px root),
   so a string row holding a single short word ("Name") still rendered a
   56px field — the row took height its content did not need. The field is
   content-driven here (`rows="1"` + `:auto-resize`), so lift the floor for
   this row's field: unlayered scoped CSS beats the preset's layered rule,
   and the height now equals exactly the content's height (one line when
   short, growing with longer values). */
.localization-string-field {
    min-height: 0;
}
</style>
