let routes;
let routes_list;


routes= [
    { path: '*', redirect: '/' }
];



//----------Middleware
import GetAssets from './middleware/GetAssets'
import IsLoggedIn from './middleware/IsLoggedIn'
//----------LayoutApp


import LayoutApp from "./../layouts/App";


routes_list =     {
    path: '/',
    component: LayoutApp,
    props: true,
    meta: {
        middleware: [
            IsLoggedIn
        ]
    },
    children: [
        {

        },
    ]
};

routes.push(routes_list);
//----------/LayoutApp


export default routes;
