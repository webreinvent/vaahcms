<template>

        <b-menu>
            <b-menu-list label="Settings">
                <b-menu-item label="Localization"
                             tag="router-link"
                             :active="!!($route.path == '/vaah/settings/localization/')"
                             :to="{name: 'loc.list'}">

                </b-menu-item>
            </b-menu-list>
        </b-menu>



<!--    <div class="">-->

<!--        <div class="sidebar-body has-padding-top-10">-->
<!--            <ul class="sidebar-nav">-->
<!--                <li class="nav-label mg-b-15">Settings</li>-->
<!--                <li class="nav-item">-->

<!--                    <router-link href="/settings"-->
<!--                         :class="{'active': $route.matched[0].path == '/settings/localization'}"-->
<!--                         :to="{ path: '/settings/localization'}" exact-->
<!--                         class="nav-link">-->
<!--                        Localization-->
<!--                    </router-link>-->
<!--                </li>-->



<!--                &lt;!&ndash;<li class="nav-item show">-->
<!--                    <a href="" class="nav-link with-sub"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><path d="M12.89 1.45l8 4A2 2 0 0 1 22 7.24v9.53a2 2 0 0 1-1.11 1.79l-8 4a2 2 0 0 1-1.79 0l-8-4a2 2 0 0 1-1.1-1.8V7.24a2 2 0 0 1 1.11-1.79l8-4a2 2 0 0 1 1.78 0z"></path><polyline points="2.32 6.16 12 11 21.68 6.16"></polyline><line x1="12" y1="22.76" x2="12" y2="11"></line><line x1="7" y1="3.5" x2="17" y2="8.5"></line></svg> Utilities</a>-->
<!--                    <nav class="nav">-->
<!--                        <a href="util-animation.html">Animation</a>-->
<!--                        <a href="util-background.html">Background</a>-->
<!--                        <a href="util-border.html">Border</a>-->
<!--                        <a href="util-display.html">Display</a>-->
<!--                        <a href="util-divider.html">Divider</a>-->
<!--                        <a href="util-flex.html">Flex</a>-->
<!--                        <a href="util-height.html">Height</a>-->
<!--                        <a href="util-margin.html">Margin</a>-->
<!--                        <a href="util-padding.html">Padding</a>-->
<!--                        <a href="util-position.html">Position</a>-->
<!--                        <a href="util-typography.html">Typography</a>-->
<!--                        <a href="util-width.html">Width</a>-->
<!--                        <a href="util-extras.html">Extras</a>-->
<!--                    </nav>-->
<!--                </li>&ndash;&gt;-->

<!--            </ul>-->
<!--        </div>-->

<!--    </div>-->

</template>

<script>
    export default {
        name: "AsideMenu",
    }
</script>

<style scoped>

</style>
