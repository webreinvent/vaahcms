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
                <h4 class="font-semibold text-sm">{{ store.assets.language_strings.multi_factor_authentication }}</h4>
                <p class="text-color-secondary text-xs font-semibold">{{ store.assets.language_strings.multi_factor_authentication_message }}</p>
                <Message severity="error"
                         class="p-container-message"
                         :closable="false"
                         icon="pi pi-exclamation-triangle"
                         v-if="!store.is_smtp_configured"
                >

                    <div class="flex">
                        You haven't configured SMTP. Please configured SMTP to enable <strong>&nbsp; Email OTP Verification &nbsp;</strong> method.
                    </div>
                </Message>
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
                    <h5 class="font-semibold text-sm mb-2">{{ store.assets.language_strings.mfa_methods }}</h5>
                    <div class="field-checkbox">
                        <Checkbox :disabled="store.list.mfa_status === 'disable' || !store.is_smtp_configured"
                                  :data-testid="'general-securities_status_'+store.list.mfa_methods"
                                  inputId="binary1" class="is-small"
                                  v-model="store.list.mfa_methods"
                                  value="email-otp-verification" />
                        <label for="binary1">{{ store.assets.language_strings.email_otp_verification }}</label>
                    </div>

                    <div class="field-checkbox align-items-start">
                        <Checkbox disabled inputId="binary3"
                                  :data-testid="'general-securities_status_'+store.list.mfa_methods"
                                  class="is-small"
                                  v-model="store.list.mfa_methods"
                                  value="authenticator-app" />
                        <label for="binary3">
                            {{ store.assets.language_strings.authenticator_app }}
                            <small class="block text-red-500 mt-1">{{ store.assets.language_strings.authenticator_app_message }}</small>
                        </label>
                    </div>
                </div>

                <div class="field flex align-items-center">
                    <InputSwitch inputId="switch1"
                                 data-testid="general-securities_status_is_new_device"
                                 class="p-inputswitch-sm mr-2"
                                 v-model="store.list.is_new_device_verification_enabled"/>
                    <label for="switch1" class="m-0">{{ store.assets.language_strings.mfa_switch_text }}</label>
                </div>
                <div class="col-12 pb-0">
                    <Divider class="mt-0 mb-3"/>

                    <Button :label="store.assets.language_strings.securities_save_button"
                            icon="pi pi-save"
                            data-testid="general-securities_save"
                            @click="store.storeSecuritySettings()"
                            class="p-button-sm"
                    />

                </div>

            </div>
        </div>
    </div>
</template>
