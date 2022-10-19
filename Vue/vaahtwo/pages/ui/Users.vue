<template>
<div class="grid">
    <div class="col-4"></div>
    <div class="col-12 md:col-4">
        <UsersForm></UsersForm>
    </div>
    <div class="col-12 md:col-4">
        <UserDetials></UserDetials>
    </div>
</div>
</template>

<script>
import UsersForm from "../../components/partials/UsersForm.vue";
import UserDetials from "../../components/partials/UserDetials.vue";
export default {
    name: "Users",
    components: {UserDetials, UsersForm},
    data(){
        return{
            user_view:'create',
            user_view_options:[
                {
                    label:'Create User',
                    value:'create'
                },
                {
                    label:'View User',
                    value:'view'
                },
                {
                    label:'Edit User',
                    value: 'edit'
                }
            ]
        }
    }
}
</script>

<style scoped>

</style>
