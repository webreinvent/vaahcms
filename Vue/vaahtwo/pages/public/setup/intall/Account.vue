<script setup>

// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });

import {onMounted, reactive} from "vue";

import { useSetupStore } from '../../../../stores/setup'
const store = useSetupStore();
import { useRootStore } from '../../../../stores/root'
const root = useRootStore();


onMounted(async () => {
    document.title = 'Account - Setup';
});

</script>

<template>
    <div v-if="store && store.assets">
        <div class="p-card">
            <div class="p-card-content p-4 border-round-xl">
        <Message severity="info" :closable="true" class="vc-dense"
                 :pt="{
                      text: {
                               'data-testid': `account-message_text`
                             },
                      closebutton:{
                          'data-testid': `account-message_close_btn`,
                      }
                  }">
            Create first account, this account will have super administrator
            role and will have all the permissions.
        </Message>
        <Fluid class="grid">
            <div class="col-12 md:col-3">
                <!-- M6-T5 — `is-6` (PrimeFlex) is 10.5px at the 14px
                     root: below the 12px floor. The field label is body
                     copy at 14px. -->
                <div class="text-left p-1 title vc-text-14" id="acct-first-name">First name</div>
                <InputGroup>
                    <InputText aria-labelledby="acct-first-name" size="small" v-model="store.config.account.first_name" name="account-first_name" data-testid="account-first_name" placeholder="Enter first name" class="" required />
                    <div class="required-field hidden"></div>
                </InputGroup>
            </div>
            <div class="col-12 md:col-3">
                <div class="text-left p-1 title vc-text-14" id="acct-middle-name">Middle name</div>
                <InputGroup>
                    <InputText aria-labelledby="acct-middle-name" size="small" v-model="store.config.account.middle_name" name="account-middle_name" data-testid="account-middle_name" placeholder="Enter middle name" class=""/>
                </InputGroup>
            </div>
            <div class="col-12 md:col-3">
                <div class="text-left p-1 title vc-text-14" id="acct-last-name">Last name</div>
                <InputGroup>
                    <InputText aria-labelledby="acct-last-name" size="small" v-model="store.config.account.last_name" name="account-last_name" data-testid="account-last_name" placeholder="Enter last name" class="" required />
                    <div class="required-field hidden"></div>
                </InputGroup>
            </div>
            <div class="col-12 md:col-3">
                <div class="text-left p-1 title vc-text-14" id="acct-email">Email</div>
                <InputGroup>
                    <InputText aria-labelledby="acct-email" size="small" v-model="store.config.account.email" name="account-email" data-testid="account-email" @blur="store.generateUsername()" placeholder="Enter email" class="" required />
                    <div class="required-field hidden"></div>
                </InputGroup>
            </div>
        </Fluid>
        <Fluid class="grid">
            <div class="col-12 md:col-3">
                <div class="text-left p-1 title vc-text-14" id="acct-username">Username</div>
                <InputGroup>
                    <InputText aria-labelledby="acct-username" size="small" v-model="store.config.account.username" name="account-username" data-testid="account-username" placeholder="Enter Username" class="" required />
                    <div class="required-field hidden"></div>
                </InputGroup>
            </div>
            <div class="col-12 md:col-3">
                <div class="text-left p-1 title vc-text-14" id="acct-password">Password</div>
                <InputGroup>
                    <Password aria-labelledby="acct-password" size="small" v-model="store.config.account.password" name="account-password" data-testid="account-password" :feedback="false" toggleMask input-class="w-full" placeholder="Enter password" :pt="{ root: { required: '' }, showicon: { 'data-testid': `account-password_eye` } }"/>
                    <div class="required-field hidden"></div>
                </InputGroup>
            </div>
            <div class="col-12 md:col-3">
                <div class="text-left p-1 title vc-text-14" id="acct-country">Search Country</div>
                <InputGroup>
                    <AutoComplete aria-labelledby="acct-country" size="small" v-model="store.config.account.country_calling_code_object" :suggestions="store.filtered_country_codes" :completeOnFocus="store.autocomplete_on_focus" @complete="store.searchCountryCode" @item-select="store.onSelectCountryCode" placeholder="Enter Your Country" optionLabel="name" name="account-country_calling_code" data-testid="account-country_calling_code" input-class="" required />
                    <div class="required-field hidden"></div>
                </InputGroup>
            </div>
            <div class="col-12 md:col-3">
                <div class="text-left p-1 title vc-text-14" id="acct-phone">Phone</div>
                <InputGroup>
                    <InputText aria-labelledby="acct-phone" size="small" v-model="store.config.account.phone" name="account-phone" data-testid="account-phone" placeholder="Enter phone" class="" required />
                    <div class="required-field hidden"></div>
                </InputGroup>
            </div>
        </Fluid>
        <Fluid class="grid">
            <div class="col-12 mt-3">
                <Button size="small" v-if="store.config.is_account_created" name="account-create_account_btn" data-testid="account-create_account_btn_created" icon="pi pi-check" label="Create Account" class="p-button-success w-auto vc-dense" :loading="store.config.btn_is_account_creating" :pt="{ label: { 'data-testid': `account-create_account_btn_text` } }"/>
                <Button size="small" v-else name="account-create_account_btn" data-testid="account-create_account_btn" icon="pi pi-check" outlined severity="info" label="Create Account" class=" w-auto vc-dense" :loading="store.config.btn_is_account_creating" @click="store.createAccount()" :pt="{ label: { 'data-testid': `account-create_account_btn_text` } }"/>

            </div>
            <div class="col-12">
                <div class="flex justify-content-between mt-3">
                    <Button size="small" label="Back" name="account-back_btn" data-testid="account-back_btn" class=" w-auto" @click="$router.push('/setup/install/dependencies')" :pt="{ label: { 'data-testid': `account-back_btn_text` } }"></Button>
                    <Button size="small" v-if="store.config.is_account_created" name="account-back_to_sign_in_btn" data-testid="account-back_to_sign_in_btn_created" icon="pi pi-external-link" label="Go to Backend Sign in" class="p-button-success w-auto" @click="store.validateAccountCreation()" :pt="{ label: { 'data-testid': `account-back_to_sign_in_btn_text` } }"></Button>
                    <Button size="small" v-else name="account-back_to_sign_in_btn" data-testid="account-back_to_sign_in_btn" icon="pi pi-external-link" label="Go to Backend Sign in" class="vaah-btn-primary w-auto" @click="store.validateAccountCreation()" :pt="{ label: { 'data-testid': `account-back_to_sign_in_btn_text` } }"></Button>
                </div>
            </div>
        </Fluid>
    </div>
        </div>
    </div>
</template>

<style scoped>

</style>
