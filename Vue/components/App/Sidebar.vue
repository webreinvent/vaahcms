<template>
    <div class="sidebar-page">
        <section class="sidebar-layout" v-if="root && root.assets">
            <div class="b-sidebar">
                <!---->
                <div class="sidebar-content is-light is-fixed
                    is-fullheight  is-mini-expand
                    is-fullwidth-mobile"
                     :class="{ 'is-mini' : root.is_sidebar_reduced }">
                    <div class="brand">
                        <p class="brand-cover"
                           :class="{ 'show-logo' : !root.is_sidebar_reduced }">
                            <img :src="root.assets.backend_logo_url">
                        </p>
                    </div>
                    <div class="menu is-custom-mobile">

                        <template v-if="root.assets && root.assets.extended_views" >
                            <template  v-for="(menu , menu_label) in root.assets.extended_views.sidebar_menu.success">
                                <ul  class="menu-list">
                                    <template  v-for="(link, menu_key) in menu">
                                        <li v-if="link.child">
                                            <a :data-wdio="getDataWdio(link,menu_label)"
                                               :class="{ 'is-active' : active_menus.includes(link.label)}"
                                               @click="toggleMenu(link.label)" class="icon-text">
                                                <b-icon v-if="link.icon"
                                                        :icon="link.icon"
                                                        size="is-small">
                                                </b-icon>
                                                <span> {{ link.label }}
                                                    <b-icon class="is-pulled-right"
                                                            :icon="active_menus.includes(link.label) ? 'chevron-down' : 'chevron-up'"></b-icon>
                                                </span>
                                            </a>

                                            <ul class="menu-list"
                                                :class="{ 'is-hidden' : !active_menus.includes(link.label)}">
                                                <template v-for="(link_child, key) in link.child">
                                                    <li v-if="link_child.child">
                                                        <a :data-wdio="getDataWdio(link_child,menu_label)"
                                                           :class="{ 'is-active' : active_menus.includes(link_child.label)}"
                                                           @click="toggleMenu(link_child.label,link.label)"
                                                           class="icon-text">
                                                            <b-icon v-if="link_child.icon"
                                                                    :icon="link_child.icon"
                                                                    size="is-small">
                                                            </b-icon>
                                                            <span> {{ link_child.label }}
                                                                <b-icon class="is-pulled-right"
                                                                        :icon="active_menus.includes(link_child.label) ? 'chevron-down' : 'chevron-up'"></b-icon>
                                                            </span>
                                                        </a>

                                                        <ul class="menu-list"
                                                            :class="{ 'is-hidden' : !active_menus.includes(link_child.label)}">
                                                            <template v-for="(link_sub_child, index) in link_child.child">
                                                                <li>
                                                                    <a :href="link_sub_child.link"
                                                                       :data-wdio="getDataWdio(link_sub_child,menu_label)" class="icon-text">
                                                                        <b-icon v-if="link_sub_child.icon"
                                                                                :icon="link_sub_child.icon"
                                                                                size="is-small">
                                                                        </b-icon>
                                                                        <span> {{ link_sub_child.label }} </span>
                                                                    </a>

                                                                    <!---->

                                                                </li>
                                                            </template>
                                                        </ul>

                                                        <!---->

                                                    </li>
                                                    <li v-else>
                                                        <a :href="link_child.link"
                                                           :data-wdio="getDataWdio(link_child,menu_label)" class="icon-text">
                                                            <b-icon v-if="link.icon"
                                                                    :icon="link_child.icon"
                                                                    size="is-small">
                                                            </b-icon>
                                                            <span> {{ link_child.label }} </span>
                                                        </a>

                                                        <!---->

                                                    </li>
                                                </template>
                                            </ul>

                                            <!---->

                                        </li>
                                        <li v-else>
                                            <a :href="link.link"
                                               :data-wdio="getDataWdio(link,menu_label)" class="icon-text">
                                                <b-icon :icon="link.icon"
                                                        size="is-small">
                                                </b-icon>
                                                <span> {{ link.label }} </span>
                                            </a>

                                            <!---->

                                        </li>

<!--                                        :class="link.link.includes($route.fullPath)?'is-active':''"-->
                                    </template>
                                </ul>
                            </template>
                        </template>


                    </div>
                </div>
            </div>
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
            active_menus:[],
            reduce: true
        };
    },
    mounted() {

        console.log(window.location.href);
    },
    methods: {
        getDataWdio: function (item,label) {
            let value = label+'-sidebar-'+this.$vaah.strToSlug(item.label);

            if(item.data_wdio){
                value = item.data_wdio;
            }

            return value;
        },
        toggleMenu: function (label,parent_label = null) {

            if(this.active_menus.includes(label)){

                var index = this.active_menus.indexOf(label);
                if (index !== -1) {
                    this.active_menus.splice(index, 1);
                }

            }else{
                this.active_menus = [label,parent_label];
            }

        },
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
