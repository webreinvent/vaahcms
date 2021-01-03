<template>
    <div class="sidebar-page">
        <section class="sidebar-layout">
            <b-sidebar
                :fullheight="true"
                position="fixed"
                :mobile="mobile"
                :expand-on-hover="expandOnHover"
                :reduce="root.is_sidebar_reduced"
                open
                type="is-light">
                <div  v-if="assets">

                    <div class="brand" >

                        <p class="brand-cover" :class="{'show-logo': root.is_sidebar_reduced == false}">
                            <img
                             :src="assets.urls.image+'/vaahcms-logo.svg'">
                        </p>

                    </div>
                    <b-menu class="is-custom-mobile">
                        <b-menu-list label="">
                            <b-menu-item icon="user" label="Info"></b-menu-item>
                            <b-menu-item active expanded icon="cog" label="Administrator">
                                <b-menu-item icon="cog" label="Users"></b-menu-item>
                                <b-menu-item icon="cog" label="Devices"></b-menu-item>
                            </b-menu-item>
                            <b-menu-item icon="user" label="My Account">
                                <b-menu-item icon="account-box" label="Account data"></b-menu-item>
                                <b-menu-item icon="home-account" label="Addresses"></b-menu-item>
                            </b-menu-item>
                        </b-menu-list>
                        <b-menu-list>
                            <b-menu-item label="Expo" icon="link"></b-menu-item>
                        </b-menu-list>

                    </b-menu>
                </div>
            </b-sidebar>


        </section>
    </div>
</template>

<script>
export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        assets() {return this.$store.getters['root/state'].assets},
    },
    data() {
        return {
            expandOnHover: true,
            mobile: "fullwidth",
            reduce: true
        };
    }
};
</script>

<style lang="scss">

.b-sidebar{

    .brand{
        width:100%;
        text-align: center;
        border-bottom: 1px solid #dddeee;
        margin-bottom: 10px;
        .brand-cover{
            padding-left: 10px;
            padding-top: 7px;
            padding-bottom: 7px;

            img{
                clip-path: inset(0% 72% 0% 0%);
                max-height:30px;
                height: 30px;
                max-width: none;
            }
        }

    }

    :hover{
        .brand{
            .brand-cover{
                padding-left: 0px !important;
                transition: 0.4s all ease;
                img{
                    clip-path: inset(0% 0% 0% 0%);
                }
            }
        }
    }


    .show-logo{
            padding-left: 0px !important;
            img{
                clip-path: inset(0% 0% 0% 0%) !important;
            }
    }

    .menu{
        .menu-list{
            a{
                &.is-active{
                    border-radius: 0px;
                }
            }
        }
    }


}

.sidebar-page {
    display: flex;
    flex-direction: column;
    width: 100%;
    min-height: 100%;
    // min-height: 100vh;
    .sidebar-layout {
        display: flex;
        flex-direction: row;
        min-height: 100%;
        // min-height: 100vh;
    }
}
@media screen and (max-width: 1023px) {
    .b-sidebar {
        .sidebar-content {
            &.is-mini-mobile {
                &:not(.is-mini-expand),
                &.is-mini-expand:not(:hover) {
                    .menu-list {
                        li {
                            a {
                                span:nth-child(2) {
                                    display: none;
                                }
                            }
                            ul {
                                padding-left: 0;
                                li {
                                    a {
                                        display: inline-block;
                                    }
                                }
                            }
                        }
                    }
                    .menu-label:not(:last-child) {
                        margin-bottom: 0;
                    }
                }
            }
        }
    }
}
@media screen and (min-width: 1024px) {
    .b-sidebar {
        .sidebar-content {
            &.is-mini {

                &:not(.is-mini-expand),
                &.is-mini-expand:not(:hover) {
                    .menu-list {
                        li {
                            a {
                                span:nth-child(2) {
                                    display: none;
                                }
                            }
                            ul {
                                padding-left: 0;
                                li {
                                    a {
                                        display: inline-block;
                                    }
                                }
                            }
                        }
                    }
                    .menu-label:not(:last-child) {
                        margin-bottom: 0;
                    }
                }
            }
        }
    }
}
</style>
