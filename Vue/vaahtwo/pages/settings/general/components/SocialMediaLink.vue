<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";
import { vaah } from "../../../../vaahvue/pinia/vaah";
import { useRootStore } from "../../../../stores/root";

const root = useRootStore();
const store = useGeneralStore();
const useVaah = vaah();
</script>

<template>
    <div v-if="store">
        <div class="grid">
            <div class="col-12 md:col-4" v-for="(item,index) in store.social_media_links">
                <h5 class="p-1 text-xs mb-1">{{ useVaah.toLabel(item.label) }}</h5>

                <div class="p-inputgroup p-fluid">
                    <span class="p-input-icon-left">
                        <i :class="item.icon?'pi z-5 '+item.icon:'pi z-5 pi-link'"/>
{{root.assets.language_string.general_settings.social_media_and_links_placeholder_text_enter}}
                        <InputText type="text"
                                   :data-testid="'general-'+item.label+'field'"
                                   v-model="item.value"
                                   :placeholder="root.assets.language_string.general_settings.social_media_links_placeholder_text_enter +' '+ item.label +' '+ root.assets.language_string.general_settings.social_media_links_placeholder_text_link"
                                   class="w-full p-inputtext-sm"
                        />
                    </span>

                    <Button icon="pi pi-copy"
                            data-testid="general-link_copy"
                            :disabled="!item.id"
                            @click="store.getCopy(item.key)"
                            class="p-button-sm"
                    />

                    <Button icon="pi pi-trash"
                            data-testid="general-link_remove"
                            @click="store.removeVariable(item)"
                            class="p-button-danger p-button-sm"
                    />
                </div>
            </div>
        </div>

        <div class="grid">
            <div class="col-12 md:col-4">
                <h5 class="p-1 text-xs mb-1">{{root.assets.language_string.general_settings.add_link}}</h5>
                <div class="p-inputgroup">
                    <InputText v-model="store.add_link"
                               data-testid="general-add_link_field"
                               icon= "pi pi-link"
                               v-if="store.show_link_input"
                               class="p-inputtext-sm"
                    />

                    <Button :label="root.assets.language_string.general_settings.add_link_button"
                            icon="pi pi-plus"
                            class="p-button-sm"
                            data-testid="general-add_link_btn"
                            :disabled="!store.add_link"
                            @click="store.addLinkHandler"
                    />
                </div>
            </div>

            <div class="col-12">
                <Divider class="mt-0 mb-3"/>
                <div class="p-inputgroup justify-content-end">
                    <Button :label="root.assets.language_string.general_settings.social_media_and_links_save_button"
                            icon="pi pi-save"
                            data-testid="general-link_save"
                            @click="store.storeLinks()"
                            class="p-button-sm"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
