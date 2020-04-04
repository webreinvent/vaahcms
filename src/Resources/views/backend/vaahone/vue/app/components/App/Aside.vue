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
                    <li><a href="#">
                        <b-icon
                                pack="fas"
                                icon="desktop"
                                size="is-small">
                        </b-icon>
                        <label>Desktop</label></a></li>
                    <li><a href="#">
                        <b-icon
                                pack="fas"
                                icon="server"
                                size="is-small">
                        </b-icon>
                        <label>Server</label></a></li>
                    <li><a href="#">
                        <b-icon
                                pack="fas"
                                icon="calendar"
                                size="is-small">
                        </b-icon>
                        <label>Calendar</label></a></li>
                    <li><a href="#">
                        <b-icon
                                pack="fas"
                                icon="envelope"
                                size="is-small">
                        </b-icon>
                       <label>Messages

                           <b-icon
                                   pack="fas"
                                   icon="angle-right"
                                   size="is-small">
                           </b-icon>
                       </label>

                    </a>

                        <ul class="has-submenu">
                            <li><a href="#">Messages v1</a> </li>
                            <li><a href="#">Messages v2</a> </li>
                        </ul>
                    </li>
                    <li><a href="#">
                        <b-icon
                                pack="fas"
                                icon="table"
                                size="is-small">
                        </b-icon>
                        <label>Data Table

                            <b-icon
                                    pack="fas"
                                    icon="angle-right"
                                    size="is-small">
                            </b-icon>
                        </label>

                    </a>

                    <ul class="has-submenu">
                        <li><a href="#">Dashboard v1</a> </li>
                        <li><a href="#">Dashboard v2</a> </li>
                    </ul>
                    </li>
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
        },
        components:{

        },
        mounted() {
//----------------------------------------------------
            this.onLoad();
//----------------------------------------------------

//----------------------------------------------------
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

