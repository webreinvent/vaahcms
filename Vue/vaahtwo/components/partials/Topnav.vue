<template>
    <Menubar :model="items" class="top-nav-fixed">
        <template #start>
            <div class="navbar-logo">
                <img src="https://develop.jalapeno.app/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="VaahCMS">
            </div>
        </template>
        <template #item="{item}">
            <router-link :to="item.to" custom v-slot="{href, route, navigate, isActive, isExactActive}">
                <a :href="href" @click="navigate" :class="{'active-link': isActive, 'active-link-exact': isExactActive}"><i class="mr-4 pi" :class="item.icon"></i></a>
            </router-link>
        </template>
        <template #end>
            <Dropdown v-model="selectedItem" :options="dropdownItems" optionLabel="name" optionValue="link" placeholder="">
            </Dropdown>
        </template>
    </Menubar>
</template>

<script>
export default {
    name: "Topnav",
    data() {
        return {
            selectedCity1: null,
            cities: [
                {name: 'New York', code: 'NY'},
                {name: 'Rome', code: 'RM'},
                {name: 'London', code: 'LDN'},
                {name: 'Istanbul', code: 'IST'},
                {name: 'Paris', code: 'PRS'}
            ],
            items: [
                {
                    to:'/',
                    title:'',
                    icon:'pi-home'
                },
                {
                    to:'/',
                    title:'',
                    icon:'pi-link'
                }
            ],
            selectedItem:'/user',
            dropdownItems:[
                {
                    name: 'User',
                    link:'/user'
                },
                {
                    name:'Profile',
                    link:'/profile'
                },
                {
                    name:'Logout',
                    link:'/logout'
                }

            ]
        }
    }
}
</script>

<style scoped>

</style>
