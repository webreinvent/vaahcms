<template>

    <div>
        <h5 class="text-left p-1 font-semibold mb-3">Copyright Text</h5>
        <div class="p-inputgroup">
            <div class="field-radiobutton mr-2" v-for="(option, key) in options">
                <RadioButton inputId="copyright-app-name" name="city" value="app-name" v-model="copyrightText" />
                <label for="copyright-app-name">Use App Name</label>
            </div>
            <div class="field-radiobutton">
                <RadioButton inputId="copyright-custom" name="city" value="custom" v-model="copyrightText" />
                <label for="copyright-custom">Custom</label>
            </div>
        </div>
        <InputText class="w-full" v-if="copyrightText === 'custom'"></InputText>
    </div>

</template>

<script setup>

const props = defineProps(['title', 'options'])

</script>
