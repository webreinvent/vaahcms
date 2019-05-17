
Vue.use(VueRouter);

import {Navbar} from './components/navbar.js'

import {MainTemplate} from './templates/main-template.js'

import { About } from './components/about.js'
import { Home } from './components/home.js'





const router = new VueRouter({
    mode: 'history',
    base: '/packages/admin/dashboard/',
    routes: [
        {
            path: '/',
            component: Home
        },
        {   path: '/about',
            component: About
        },
        { path: '*', redirect: '/' }
    ]
});

new Vue({
    el: '#app', // This should be the same as your <div id=""> from earlier.
    components: {
        'navbar': Navbar
    },
    router,
    template: MainTemplate
})