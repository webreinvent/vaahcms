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
import Default from "./../layouts/default";


import Index from "./../pages/Index";

routes_list =     {
    path: '/',
    component: Default,
    props: true,
    children: [
        {
            path: '/',
            name: 'index',
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

import BButton from "./../vaahnuxt/buefy/pages/button";

routes_list =     {
    path: '/buefy',
    component: Default,
    props: true,
    children: [
        {
            path: '/',
            name: 'b.index',
            component: BButton,
            props: true,
        }
    ]
};

routes.push(routes_list);

export default routes;
