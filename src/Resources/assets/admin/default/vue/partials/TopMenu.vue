<template>


    <div >

        <!--app nav-->
        <nav class="navbar navbar-expand-lg navbar-app navbar-light">

            <a class="navbar-brand tx-bold tx-spacing--2" href="#">VAAH</a>

            <button class="navbar-toggler order-2" type="button" data-toggle="collapse"
                    data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                <i data-feather="menu" class="wd-20 ht-20"></i>
            </button>

            <div class="collapse navbar-collapse order-2 " id="navbarNav">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ path: '/'}">
                            Dashboard
                        </router-link>
                    </li>

                    <li class="nav-item">

                        <router-link class="nav-link"
                                     :class="{'active': $route.matched[0].path == '/registrations'}"
                                     :to="{ path: '/registrations'}" exact>
                            Registrations
                        </router-link>

                    </li>
                    <li class="nav-item ">

                        <router-link class="nav-link"
                                     :class="{'active': $route.matched[0].path == '/users'}"
                                     :to="{ path: '/users'}" exact>
                            Users
                        </router-link>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Role</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Permissions</a>
                    </li>
                    <li class="nav-item nav-separator"></li>

                    <li class="nav-item ">
                        <a class="nav-link" href="#">Permissions</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>

                </ul>



            </div>
        </nav>
        <!--/app nav-->


    </div>


</template>
<script src="./TopMenuJs.js"></script>