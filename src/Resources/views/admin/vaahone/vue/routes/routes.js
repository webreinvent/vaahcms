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
import ForgotPassword from "./../pages/ForgotPassword";


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
            name: 'sign.in',
            component: SignIn,
            props: true,
            meta: {
                middleware: [
                    GetAssets
                ]
            },
        },
        {
            path: '/forgot-password',
            name: 'forgot.password',
            component: ForgotPassword,
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
