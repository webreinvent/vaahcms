let routes;
let routes_list;


routes= [
    { path: '*', redirect: '/' }
];



//----------Middleware
import GetAssets from './middleware/GetAssets'
import IsLoggedIn from './middleware/IsLoggedIn'
//----------LayoutApp


import LayoutPublic from "./../layouts/Public";
import LayoutAdmin from "./../layouts/Admin";

import SignIn from "./../pages/SignIn";


routes_list =     {
    path: '/',
    component: LayoutPublic,
    props: true,
    meta: {
        middleware: [
            GetAssets
        ]
    },
    children: [
        {
            path: '/',
            name: 'sign_in',
            component: SignIn,
            props: true,
            meta: {
                middleware: [
                    GetAssets
                ]
            },
        }

    ]
};

routes.push(routes_list);
//----------/LayoutApp


export default routes;
