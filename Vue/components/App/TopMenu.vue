<template>

        <b-navbar v-if="root" class="has-shadow"  :fixed-top="false">
            <template slot="brand">

                <b-navbar-item class="has-padding-left-20"
                               @click="toggleSidebar">
                    <b-icon
                        pack="fas"
                        icon="bars"
                        size="is-small">
                    </b-icon>
                </b-navbar-item>

                <b-navbar-item @click="toggleSidebar">
                    <b-icon
                        pack="fas"
                        icon="home"
                        size="is-small">
                    </b-icon>
                </b-navbar-item>

                <b-navbar-item class="has-padding-left-10"
                               target="_blank"
                               :href="root.assets.urls.public">
                    <b-tooltip label="Visit Site"
                               position="is-bottom">
                        <b-icon
                            pack="fas"
                            icon="external-link-alt"
                            size="is-small">
                        </b-icon>
                    </b-tooltip>
                </b-navbar-item>

            </template>

            <template slot="start" v-if="root.assets.extended_views" >

                <template  v-for="menus in root.assets.extended_views.top_left_menu.success">

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

            <template slot="end" v-if="root.assets && root.assets.auth_user">

                {{root.has_left_padding}}

                <b-navbar-dropdown :right="true"
                                   :hoverable="true"
                                   :label="root.assets.auth_user.name">

                    <template  v-for="menus in root.assets.extended_views.top_right_user_menu.success">

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
        props:['root'],
        computed:{
        },
        components:{
        },
        data()
        {
            let obj = {
            };

            return obj;
        },
        mounted() {
            //----------------------------------------------------
            this.onLoad();
            //----------------------------------------------------
        },
        methods: {
            onLoad: function()
            {

            },
            //----------------------------------------------------
            toggleSidebar: function()
            {
                let payload;

                if(this.root.is_sidebar_reduced)
                {
                    payload = {
                        'is_sidebar_reduced': false,
                        'has_padding_left': this.root.expanded_padding_left
                    }

                } else {

                    payload = {
                        'is_sidebar_reduced': true,
                        'has_padding_left': this.root.default_padding_left
                    }

                }

                console.log('--->payload', payload);


                this.$emit('sidebar-action', payload)

            }
            //----------------------------------------------------
            //----------------------------------------------------

        }
    }

</script>
