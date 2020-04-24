<template>
    <div class="aside">
    <!--sections-->
        <div class="menu-action">
            <b-icon
                    pack="fas"
                    icon="bars"
                    size="is-small">
            </b-icon>
        </div>
        <div class="menu">
            <div class="sidebar">
                <ul>
                    <template v-if="assets && assets.extended_views" >
                        <template  v-for="menus in assets.extended_views.sidebar_menu">
                            <template v-for="link in menus">
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
        computed:{
            root() {return this.$store.getters['root/state']},
            assets() {return this.$store.getters['root/state'].assets},
        },
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

