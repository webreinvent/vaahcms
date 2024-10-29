<template>
    <Menubar :model="items" class="top-nav-fixed py-2 align-items-center">
        <template #start>
            <div class="navbar-logo">
                <img src="https://develop.jalapeno.app/vaahcms/backend/vaahone/images/vaahcms-logo.svg" alt="VaahCMS">
            </div>
        </template>
        <template #item="{item}">
            <router-link :to="item.to" custom v-slot="{href, route, navigate, isActive, isExactActive}">
                <a :href="href" @click="navigate" class=" text-black mx-2"><i class="pi" :class="item.icon"></i></a>
            </router-link>
        </template>
        <template #end>
           <div class="flex align-items-center">
               <a @click="toggle" class="cursor-pointer flex align-items-center">
                   <Avatar image="https://www.gravatar.com/avatar/98431994177b4bb856d3f03dbee7ba03.jpg?s=80&d=mp&r=g" class="mr-2" shape="circle" />
                   <span>Jhon Doe </span>
                   <i class="pi pi-chevron-down text-sm mt-1 ml-1"></i>
               </a>
           </div>
            <TieredMenu :model="menu_options" ref="menu" :popup="true">
            </TieredMenu>
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
                    icon:'pi pi-home'
                },
                {
                    to:'/',
                    title:'',
                    icon:'pi pi-link'
                }
            ],
            selectedItem:'/user',
            menu_options:[
                {
                    label:'Profile',
                    icon:'pi pi-fw pi-user',
                    to:{path:'/ui/private/profile'}
                },
                {
                    label:'Logout',
                    icon:'pi pi-fw pi-sign-out',
                     command: () =>{
                    }
                }
            ],
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
    },
    methods:{
        toggle(event) {
            this.$refs.menu.toggle(event);
        }
    }
}
</script>

<style scoped>

</style>
