let routes;
let routes_list;


routes= [
    { path: '*', redirect: '/' }
];



//----------Middleware
import GetAssets from './middleware/GetAssets'
import IsLoggedIn from './middleware/IsLoggedIn'
//----------LayoutApp




/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
import Default from "./../layouts/Default";

import Index from "./../pages/Index";

routes_list =     {
    path: '/',
    component: Default,
    props: true,
    children: [
        {
            path: '/',
            name: 'home',
            component: Index,
            props: true,
        }
    ]
};

routes.push(routes_list);

/*
|--------------------------------------------------------------------------
| Buefy Routes
|--------------------------------------------------------------------------
*/

import Ui from "./../layouts/Ui";

import button from "./../vaahnuxt/buefy/pages/button";
import carousel from "./../vaahnuxt/buefy/pages/carousel";
import collapse from "./../vaahnuxt/buefy/pages/collapse";
import dialog from "./../vaahnuxt/buefy/pages/dialog";
import icon from "./../vaahnuxt/buefy/pages/icon";



routes_list =     {
    path: '/ui/buefy',
    component: Ui,
    props: true,
    children: [
        {
            path: '/',
            name: 'bue.index',
            component: button,
            props: true,
        },
        {
            path: 'button',
            name: 'bue.button',
            component: button,
            props: true,
        },
        {
            path: 'carousel',
            name: 'bue.carousel',
            component: carousel,
            props: true,
        },
        {
            path: 'collapse',
            name: 'bue.collapse',
            component: collapse,
            props: true,
        },
        {
            path: 'dialog',
            name: 'bue.dialog',
            component: dialog,
            props: true,
        },
        {
            path: 'icon',
            name: 'bue.icon',
            component: icon,
            props: true,
        }
    ]
};

routes.push(routes_list);

export default routes;
