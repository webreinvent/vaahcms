let routes= [];
let routes_list= [];

import LayoutPublic from '../layouts/Public.vue'
import Signin from '../pages/public/Signin.vue'
import Setup from '../pages/public/setup/Index.vue'
import SetupInstall from '../pages/public/setup/intall/Index.vue'


routes_list = [
    {
        path: '/',
        component: LayoutPublic,
        props: true,
        children: [
            {
                path: '/',
                name: 'sign.in',
                component: Signin,
                props: true,
            },
            {
                path: '/setup',
                name: 'setup',
                component: Setup,
                props: true,
            },
            {
                path: '/setup/install',
                name: 'setup.install',
                component: SetupInstall,
                props: true,
            },
        ]
    }
];

routes.push(...routes_list);

export default routes;

