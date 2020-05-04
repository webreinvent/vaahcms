<template>

        <b-navbar v-if="assets" class="has-shadow" :fixed-top="true">
            <template slot="brand">
                <b-navbar-item  :to="{ path: '/' }">
                    <img v-if="assets"
                         height="30"
                         :src="assets.urls.image+'/vaahcms-logo.svg'">
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
    export default {
        props:['assets'],
        components:{
        },
        mounted() {
            //----------------------------------------------------
            this.onLoad();
            //----------------------------------------------------
        },
        methods: {
            onLoad: function()
            {
                /*main menu expand*/
                $('.menu-action').click(function(event) {
                    $('.sidebar').toggleClass('active');
                    $(this).toggleClass('active');
                    if ($('.sidebar').hasClass('active')) {
                        $(this).find('span.icon').addClass('close');
                        $(this).find('span.icon').removeClass('bars');
                    } else {
                        $(this).find('span.icon').addClass('bars');
                        $(this).find('span.icon').removeClass('close');
                        $('.sidebar').find('li').removeClass('active');
                        $('.sidebar').find('ul ul:visible').hide();
                    }
                    event.stopPropagation();
                });
                $(document).click( function(){
                    $('.sidebar').removeClass('active');
                    $('.menu-action').removeClass('active');
                });
                /*sub menu open and close*/
                var animationSpeed = 300,
                    subMenuSelector = '.has-submenu';
                $('.sidebar').on('click', 'li a', function(e) {
                    var $this = $(this);
                    var checkElement = $this.next();
                    if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
                        checkElement.slideUp(animationSpeed, function() {
                            checkElement.removeClass('menu-open');
                            $('.sidebar').removeClass('active');
                        });
                        checkElement.parent("li").removeClass("active");
                    }
                    //If the menu is not visible
                    else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
                        //Get the parent menu
                        var parent = $this.parents('ul').first();
                        //Close all open menus within the parent
                        var ul = parent.find('ul:visible').slideUp(animationSpeed);
                        //Remove the menu-open class from the parent
                        ul.removeClass('menu-open');
                        //Get the parent li
                        var parent_li = $this.parent("li");
                        //Open the target menu and add the menu-open class
                        checkElement.slideDown(animationSpeed, function() {
                            //Add the class active to the parent li
                            checkElement.addClass('menu-open');
                            parent.find('li.active').removeClass('active');
                            parent_li.addClass('active');
                            $('.sidebar').addClass('active');
                        });
                    }
                    //if this isn't a link, prevent the page from being redirected
                    if (checkElement.is(subMenuSelector)) {
                        e.preventDefault();
                    }
                });
            },
        }
    }

</script>
