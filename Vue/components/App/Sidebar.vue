<template>
    <div class="sidebar-page">
        <section class="sidebar-layout" v-if="root && root.assets">
            <b-sidebar
                    ref="vh_sidebar"
                :can-cancel="false"
                :fullheight="true"
                position="fixed"
                :mobile="mobile"
                :expand-on-hover="expandOnHover"
                :reduce="root.is_sidebar_reduced"
                open
                type="is-light">
                <template>

                    <div class="brand" >
                        <p class="brand-cover" :class="{'show-logo': root.is_sidebar_reduced == false}">
                            <img
                             :src="root.assets.urls.image+'/vaahcms-logo.svg'">
                        </p>

                    </div>

                    <b-menu class="is-custom-mobile">

                        <template v-if="root.assets && root.assets.extended_views" >
                            <template  v-for="menu in root.assets.extended_views.sidebar_menu.success">
                                <b-menu-list v-for="(link, menu_key) in menu" :key="menu_key    ">

                                    <b-menu-item v-if="link.child"
                                                 :icon="link.icon">

                                        <template #label="props">
                                            <span>
                                                {{link.label}}
                                                <b-icon class="is-pulled-right" :icon="props.expanded ? 'chevron-down' : 'chevron-up'"></b-icon>
                                            </span>
                                        </template>

                                        <template v-for="(link_child, key) in link.child">
                                            <b-menu-item v-if="link_child.child"
                                                         :key="key"
                                                         :icon="link_child.icon">

                                                <template #label="props">
                                                    <span>
                                                        {{link_child.label}}
                                                        <b-icon class="is-pulled-right" :icon="props.expanded ? 'chevron-down' : 'chevron-up'"></b-icon>
                                                    </span>
                                                </template>

                                                <b-menu-item  v-for="(link_sub_child, index) in link_child.child"
                                                              :key="index"
                                                              tag="a"
                                                              :href="link_sub_child.link"
                                                              :label="link_sub_child.label"
                                                              :icon="link_sub_child.icon">
                                                </b-menu-item>

                                            </b-menu-item>

                                            <b-menu-item v-else
                                                         :key="key"
                                                         tag="a"
                                                         :href="link_child.link"
                                                         :label="link_child.label"
                                                         :icon="link_child.icon">
                                            </b-menu-item>
                                        </template>

                                    </b-menu-item>

                                    <b-menu-item v-else
                                                 tag="a"
                                                 :href="link.link"
                                                 :label="link.label"
                                                 :icon="link.icon">
                                    </b-menu-item>

                                </b-menu-list>
                            </template>
                        </template>

                    </b-menu>
                </template>
            </b-sidebar>


        </section>
    </div>
</template>

<script>
export default {
    props:['root'],
    computed:{
    },
    data() {
        return {
            expandOnHover: true,
            mobile: "fullwidth",
            reduce: true
        };
    },
    mounted() {

    },

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
