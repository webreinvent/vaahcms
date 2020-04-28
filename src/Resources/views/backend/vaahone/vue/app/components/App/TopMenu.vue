<template>



        <b-navbar v-if="assets" class="has-shadow" :fixed-top="true">
            <template slot="brand">
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    <Logo height="30"/>
                </b-navbar-item>
            </template>

            <template slot="start" v-if="assets.extended_views" >

                <b-tooltip label="Visit Site"
                           position="is-bottom">
                    <b-navbar-item target="_blank" :href="assets.urls.public">

                        <b-icon
                            icon="external-link-alt"
                            size="is-small">
                        </b-icon>


                    </b-navbar-item>
                </b-tooltip>



                <template  v-for="menus in assets.extended_views.top_left_menu.success">

                    <template v-for="link in menus">

                        <b-navbar-dropdown v-if="link.child"
                                           :hoverable="true"
                                           :label="link.label">
                            <b-navbar-item v-for="(link_child, key) in link.child"
                                           :href="link_child.link" :key="key" >
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

            <template slot="end" v-if="assets && assets.auth_user">

                <b-navbar-dropdown :right="true"
                                   :hoverable="true"
                                   :label="assets.auth_user.name">

                    <template  v-for="menus in assets.extended_views.top_right_user_menu.success">

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
    import Logo from '../../components/Logo';
    export default {
        computed:{
            root() {return this.$store.getters['root/state']},
            assets() {return this.$store.getters['root/state'].assets},
        },
        components:{
            Logo,
        },
    }

</script>
