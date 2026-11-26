<script setup>
import { useGeneralStore } from "../../../../stores/settings/store-general_setting";
import {useRootStore} from "../../../../stores/root";
const root = useRootStore();
const store = useGeneralStore();
</script>

<template>
    <div v-if="store && store.list && store.assets && root.assets">
        <div class="grid">
            <div class="col-12">
                <h3 class="vaah-type-subhead">{{ store.assets.language_strings.multi_factor_authentication }}</h3>
                <p class="vaah-type-secondary">{{ store.assets.language_strings.multi_factor_authentication_message }}</p>
                <!-- M6-T4 (F23) — "You haven't configured SMTP" is a CAUTION,
                     not a failure: SMTP is simply not switched on yet, which the
                     contract (§2) maps to `warn` and never to `error`. It wore
                     `error` — the loudest tone on the screen — for a setting
                     the admin has not filled in yet.

                     UT-113 — the caution was the engine's `Message
                     severity="warn"`, which fills the whole box with the Nide
                     preset's literal warn fill — a solid yellow slab in light
                     mode, a brown slab in dark. It is now the app's own
                     caution band (`.vc-notice-warn`, the third member of the
                     info / error family) with the exclamation-triangle glyph
                     it already carried as the non-colour signal, so it reads
                     as a note *in* the panel rather than a slab glued to it.
                     Presentation only; the string, its source and the
                     warning's meaning are untouched. -->
                <div class="securities-notice vc-notice vc-notice-warn"
                     data-testid="general-securities-smtp-notice"
                     v-if="!store.is_smtp_configured"
                >
                    <i class="pi pi-exclamation-triangle vc-notice-icon"
                       aria-hidden="true"></i>
                    <p class="vc-notice-text"
                       v-html="store.assets.language_strings.securities_smtp_message"
                    ></p>
                </div>
            </div>
            <div class="col-12 pt-0 ">
                <div class="field">
                    <div class="field-radiobutton">
                        <RadioButton inputId="mfa-option-1"
                                     name="mfa"
                                     :data-testid="'general-securities_status_'+store.list.mfa_status"
                                     value="disable"
                                     v-model="store.list.mfa_status" />
                        <label for="mfa-option-1">{{ store.assets.language_strings.multi_factor_authentication_disable }}</label>
                    </div>
                    <div class="field-radiobutton">
                        <RadioButton inputId="mfa-option-2"
                                     name="mfa"
                                     :data-testid="'general-securities_status_'+store.list.mfa_status"
                                     value="all-users"
                                     v-model="store.list.mfa_status" />
                        <label for="mfa-option-2">{{ store.assets.language_strings.enable_for_all_users }}</label>
                    </div>
                    <div class="field-radiobutton">
                        <RadioButton inputId="mfa-option-3"
                                     name="mfa"
                                     :data-testid="'general-securities_status_'+store.list.mfa_status"
                                     value="user-will-have-option"
                                     v-model="store.list.mfa_status" />
                        <label for="mfa-option-3">{{ store.assets.language_strings.users_will_have_option_to_enable_it }}</label>
                    </div>
                </div>
                <div class="field">
                    <h3 class="vaah-type-subhead mb-2">{{ store.assets.language_strings.mfa_methods }}</h3>
                    <div class="field-checkbox">
                        <Checkbox :disabled="store.list.mfa_status === 'disable' || !store.is_smtp_configured"
                                  :data-testid="'general-securities_status_'+store.list.mfa_methods"
                                  inputId="binary1" class="vc-dense"
                                  v-model="store.list.mfa_methods"
                                  value="email-otp-verification" />
                        <label for="binary1">{{ store.assets.language_strings.email_otp_verification }}</label>
                    </div>

                    <div class="field-checkbox align-items-start">
                        <Checkbox disabled inputId="binary3"
                                  :data-testid="'general-securities_status_'+store.list.mfa_methods"
                                  class="vc-dense"
                                  v-model="store.list.mfa_methods"
                                  value="authenticator-app" />
                        <label for="binary3">
                            {{ store.assets.language_strings.authenticator_app }}
                            <small class="block vaah-type-caption mt-1 auth-note">{{ store.assets.language_strings.authenticator_app_message }}</small>
                        </label>
                    </div>
                </div>

                <div class="field flex align-items-center">
                    <ToggleSwitch inputId="switch1"
                                 data-testid="general-securities_status_is_new_device"
                                 class="mr-2"
                                 v-model="store.list.is_new_device_verification_enabled"/>
                    <label for="switch1" class="m-0">{{ store.assets.language_strings.mfa_switch_text }}</label>
                </div>
                <div class="col-12 pb-0">
                    <Divider class="mt-0 mb-3"/>

                    <Button size="small" :label="store.assets.language_strings.securities_save_button" icon="pi pi-save" data-testid="general-securities_save" @click="store.storeSecuritySettings()" class="" />

                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
/* M6-T4 (F23) — "Authenticator App is temporarily unavailable" is a
   CAUTION, not a failure: it wore the primitive `text-red-500`, which
   resolves to a scheme-invariant palette token and therefore read as a
   hard error (and stayed the same in dark mode). It now wears the warn
   tone — a semantic token that flips with the scheme. */
.auth-note {
    color: var(--vaah-msg-warn-fg);
}

/* UT-113 — the SMTP caution band needs its own gap under the heading; its
   shape and tone come from the shared `.vc-notice` / `.vc-notice-warn`
   classes in the token layer. */
.securities-notice {
    margin-bottom: 12px;
}
</style>
