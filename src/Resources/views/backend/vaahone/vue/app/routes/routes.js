let routes;
let routes_list=[];


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
import LayoutPublic from "./../layouts/Public";


import SignIn from "./../pages/SignIn";
import ForgotPassword from "./../pages/ForgotPassword";

let routes_frontend =     {
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

routes.push(routes_frontend);


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
import LayoutAdmin from "./../layouts/Admin";
import Index from "./../pages/dashboard/Index";

let routes_backend =     {
    path: '/app',
    component: LayoutAdmin,
    props: true,
    meta: {
        middleware: [
            IsLoggedIn,
            GetAssets
        ]
    },
    children: [
        {
            path: '/',
            name: 'dashboard.index',
            component: Index,
            props: true,
            meta: {
                middleware: [
                    IsLoggedIn,
                    GetAssets
                ]
            },
        }

    ]
};

routes.push(routes_backend);


export default routes;
