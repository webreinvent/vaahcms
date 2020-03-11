<template>



        <b-navbar v-if="root.assets">
            <template slot="brand">
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    <img
                        src="https://raw.githubusercontent.com/buefy/buefy/dev/static/img/buefy-logo.png"
                        alt="Lightweight UI components for Vue.js based on Bulma"
                    >
                </b-navbar-item>
            </template>

            <template slot="start" v-if="root.assets.extended_views.top_left_menu" >


                <template  v-for="menus in root.assets.extended_views.top_left_menu">

                    <template v-for="link in menus">

                        <b-navbar-dropdown v-if="link.child" :label="link.label">
                            <b-navbar-item v-for="link_child in link.child" :href="link_child.link" >
                                {{link_child.label}}
                            </b-navbar-item>
                        </b-navbar-dropdown>

                        <b-navbar-item v-else
                                       :href="link.link">
                            {{link.label}}
                        </b-navbar-item>

                    </template>

                </template>



            </template>

            <template slot="end">

                <b-navbar-dropdown :right="true" :label="root.assets.auth_user.name">

                    <template  v-for="menus in root.assets.extended_views.top_right_user_menu">

                        <template v-for="link in menus">

                            <b-navbar-item :href="link.link">
                                {{link.label}}
                            </b-navbar-item>

                        </template>

                    </template>

                </b-navbar-dropdown>


            </template>
        </b-navbar>

</template>

<script>

    export default {
        computed:{
            root() {return this.$store.getters['root/state']},
        },
    }

</script>
