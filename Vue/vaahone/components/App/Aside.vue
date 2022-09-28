<template>
    <div class="aside">
    <!--sections-->
        <div class="menu-action">
            <font-awesome-icon icon="bars" />
        </div>
        <div class="menu">
            <div class="sidebar">
                <ul>
                    <template v-if="assets && assets.extended_views" >
                        <template  v-for="menu in assets.extended_views.sidebar_menu.success">
                            <template v-for="link in menu">
                                <li>
                                    <a :href="link.link" :class="{'has-child': link.child}">
                                        <b-icon v-if="link.icon" pack="fas"
                                                :icon="link.icon"
                                                size="is-small">
                                        </b-icon>
                                        <b-icon v-else pack="fas"
                                                icon="link"
                                                size="is-small">
                                        </b-icon>
                                        <label>
                                            {{link.label}}
                                            <b-icon
                                                v-if="link.child"
                                                pack="fas"
                                                icon="angle-right"
                                                size="is-small">
                                            </b-icon>
                                        </label>
                                    </a>


                                    <ul class="has-submenu" v-if="link.child">
                                        <li v-for="(link_child, key) in link.child">
                                            <a :href="link_child.link">
                                                <b-icon v-if="link_child.icon"
                                                        pack="fas"
                                                        :icon="link_child.icon" size="is-small">
                                                </b-icon>
                                                <label>{{link_child.label}}</label>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </template>
                        </template>
                    </template>
                </ul>
            </div>
        </div>
    <!--sections-->
    </div>

</template>

<script>
    export default {
        props:['assets'],
        components:{
        },
    }
</script>

