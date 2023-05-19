<script setup>

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
        <Message severity="info" :closable="true" class="is-small">
            Create first account,this account will have super administrator role and will have all the permissions.
        </Message>
        <div class="grid p-fluid">
            <div class="col-12 md:col-3">
                <h5 class="text-left p-1 title is-6">First name</h5>
                <div class="p-inputgroup">
                    <InputText
                        v-model="store.config.account.first_name"
                        name="account-first_name"
                        data-testid="account-first_name"
                        placeholder="Enter first name"
                        class="p-inputtext-sm"/>
                </div>
            </div>
            <div class="col-12 md:col-3">
                <h5 class="text-left p-1 title is-6">Middle name</h5>
                <div class="p-inputgroup">
                    <InputText
                        v-model="store.config.account.middle_name"
                        name="account-middle_name"
                        data-testid="account-middle_name"
                        placeholder="Enter middle name"
                        class="p-inputtext-sm"/>
                </div>
            </div>
            <div class="col-12 md:col-3">
                <h5 class="text-left p-1 title is-6">Last name</h5>
                <div class="p-inputgroup">
                    <InputText
                        v-model="store.config.account.last_name"
                        name="account-last_name"
                        data-testid="account-last_name"
                        placeholder="Enter last name"
                        class="p-inputtext-sm"/>
                </div>
            </div>
            <div class="col-12 md:col-3">
                <h5 class="text-left p-1 title is-6">Email</h5>
                <div class="p-inputgroup">
                    <InputText
                        v-model="store.config.account.email"
                        name="account-email"
                        data-testid="account-email"
                        @blur="store.generateUsername()"
                        placeholder="Enter email"
                        class="p-inputtext-sm"/>
                </div>
            </div>
        </div>
        <div class="grid p-fluid">
            <div class="col-12 md:col-3">
                <h5 class="text-left p-1 title is-6">Username</h5>
                <div class="p-inputgroup">
                    <InputText
                        v-model="store.config.account.username"
                        name="account-username"
                        data-testid="account-username"
                        placeholder="Enter Username"
                        class="p-inputtext-sm"/>
                </div>
            </div>
            <div class="col-12 md:col-3">
                <h5 class="text-left p-1 title is-6">Password</h5>
                <div class="p-inputgroup">
                    <Password
                        v-model="store.config.account.password"
                        name="account-password"
                        data-testid="account-password"
                        :feedback="false"
                        toggleMask input-class="w-full p-inputtext-sm"
                        placeholder="Enter password"/>
                </div>
            </div>
            <div class="col-12 md:col-3">
                <h5 class="text-left p-1 title is-6">Search Country</h5>
                <AutoComplete
                    v-model="store.config.account.country_calling_code_object"
                    :suggestions="store.filtered_country_codes"
                    :completeOnFocus="store.autocomplete_on_focus"
                    @complete="store.searchCountryCode"
                    @blur="store.setFocusDropDownToTrue"
                    @item-select="store.onSelectCountryCode"
                    placeholder="Enter Your Country"
                    optionLabel="name"
                    name="account-country_calling_code"
                    data-testid="account-country_calling_code"
                    input-class="p-inputtext-sm"
                />
            </div>
            <div class="col-12 md:col-3">
                <h5 class="text-left p-1 title is-6">Phone</h5>
                <div class="p-inputgroup">
                    <InputText
                        v-model="store.config.account.phone"
                        name="account-phone"
                        data-testid="account-phone"
                        placeholder="Enter phone"
                        class="p-inputtext-sm"/>
                </div>
            </div>
        </div>
        <div class="grid p-fluid">
            <div class="col-12 mt-3">
                <span v-if="store.config.env.db_is_valid">
                    <Button
                        v-if="store.config.is_account_created"
                        name="account-create_account_btn"
                        data-testid="account-create_account_btn"
                        icon="pi pi-check"
                        label="Create Account"
                        class="p-button-success p-button-sm w-auto is-small"
                        :loading="store.config.btn_is_account_creating"/>
                    <Button
                        v-else
                        name="account-create_account_btn"
                        data-testid="account-create_account_btn"
                        icon="pi pi-check"
                        label="Create Account"
                        class="p-button-success p-button-sm w-auto is-small"
                        :loading="store.config.btn_is_account_creating"
                        @click="store.createAccount()"/>
                </span>
                <span v-else>
                    <Button
                        v-if="store.config.is_account_created"
                        name="account-create_account_btn"
                        data-testid="account-create_account_btn"
                        icon="pi pi-user-plus"
                        label="Create Account"
                        class="p-button-sm w-auto is-small"
                        :loading="store.config.btn_is_account_creating"/>
                    <Button
                        v-else
                        name="account-create_account_btn"
                        data-testid="account-create_account_btn"
                        icon="pi pi-user-plus"
                        label="Create Account"
                        class="p-button-sm w-auto is-small"
                        :loading="store.config.btn_is_account_creating"
                        @click="store.createAccount()"/>
                </span>
            </div>
            <div class="col-12">
                <div class="flex justify-content-between mt-3">
                    <Button
                        label="Back"
                        name="account-back_btn"
                        data-testid="account-back_btn"
                        class="p-button-sm w-auto"
                        @click="$router.push('/setup/install/dependencies')"></Button>
                    <Button
                        v-if="store.config.is_account_created"
                        name="account-back_to_sign_in_btn"
                        data-testid="account-back_to_sign_in_btn"
                        icon="pi pi-external-link"
                        label="Go to Backend Sign in"
                        class="p-button-sm w-auto"
                        @click="store.validateAccountCreation()"></Button>
                    <Button
                        v-else
                        name="account-back_to_sign_in_btn"
                        data-testid="account-back_to_sign_in_btn"
                        icon="pi pi-external-link"
                        label="Go to Backend Sign in"
                        class="p-button-sm w-auto"
                        @click="store.validateAccountCreation()"></Button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
