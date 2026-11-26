<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";
import { vaah } from "../../../../vaahvue/pinia/vaah";

const store = useGeneralStore();
const useVaah = vaah();
</script>

<template>
    <div v-if="store && store.assets">
        <div class="grid">
            <div class="col-12 md:col-4" v-for="(item,index) in store.social_media_links">
                <div class="p-1 vaah-type-caption mb-1" :id="'gsl-link-'+index">{{ useVaah.toLabel(item.label) }}</div>

                <!-- UT-117 — the link's icon was a v3 `p-input-icon-left`
                     span. That class has no rule in the v4 engine, so the
                     icon was no longer an overlay on the field: it became a
                     block above it and the whole `InputGroup` grew to 56px
                     (the icon's 20px line + the 36px field), with the two
                     action buttons stretched to that 56px. The engine's
                     `InputGroupAddon` is the v4 equivalent of the v3
                     `p-input-icon-left` wrapper — the icon is a sibling of
                     the field again and the row keeps the 36px density
                     contract. -->
                <Fluid><InputGroup>
                    <InputGroupAddon>
                        <i :class="item.icon?'pi z-5 '+item.icon:'pi z-5 pi-link'"/>
                    </InputGroupAddon>

                    <InputText :aria-labelledby="'gsl-link-'+index" size="small" type="text" :data-testid="'general-'+item.label+'field'" v-model="item.value" :placeholder="store.assets.language_strings.social_media_links_placeholder_text_enter + ' ' + item.label + ' ' + store.assets.language_strings.social_media_links_placeholder_text_link" class="w-full" />

                    <!-- UT-117 — `:fluid="false"` is load-bearing: the v4
                         `<Fluid>` component *provides* a fluid context, so
                         every Button below it (at any depth) is rendered
                         `p-button-fluid` (width: 100%). The field may stay
                         fluid (it is the elastic member); the two actions
                         may not. -->
                    <Button size="small" :fluid="false" icon="pi pi-copy" aria-label="Copy to clipboard" data-testid="general-link_copy" :disabled="!item.id" @click="store.getCopy(item.key)" class="" />

                    <Button size="small" :fluid="false" icon="pi pi-trash" aria-label="Remove link" data-testid="general-link_remove" @click="store.removeVariable(item)" class="p-button-danger" />
                </InputGroup></Fluid>
            </div>
        </div>

        <div class="grid">
            <div class="col-12 md:col-4">
                <div class="p-1 vaah-type-caption mb-1" id="gsl-link-add-link">{{ store.assets.language_strings.add_link }}</div>
                <InputGroup>
                    <!-- UT-117 — v3's `icon` prop on `InputText` was removed
                         in v4 (it is silently dropped there), so the field
                         lost its link glyph. The engine's `InputGroupAddon`
                         is the v4 way to put an icon in the field. -->
                    <InputGroupAddon v-if="store.show_link_input">
                        <i class="pi pi-link"/>
                    </InputGroupAddon>

                    <InputText aria-labelledby="gsl-link-add-link" size="small" v-model="store.add_link" data-testid="general-add_link_field" v-if="store.show_link_input" class="" />

                    <Button size="small" :label="store.assets.language_strings.add_link_button" icon="pi pi-plus" class="" data-testid="general-add_link_btn" :disabled="!store.add_link" @click="store.addLinkHandler" />
                </InputGroup>
            </div>

            <div class="col-12">
                <Divider class="mt-0 mb-3"/>
                <InputGroup class="justify-content-end">
                    <Button size="small" :label="store.assets.language_strings.social_media_and_links_save_button" icon="pi pi-save" data-testid="general-link_save" @click="store.storeLinks()" class="" />
                </InputGroup>
            </div>
        </div>
    </div>
</template>
