//---------Variables
var base_url = $('base').attr('href');
var current_url = $('#current_url').attr('content');
var debug = $('#debug').attr('content');
//---------/Variables

let urls = {
    base: base_url,
    current: current_url,
};

import Dashboard from "./dashboard/Dashboard";

const routes= [
    {   path: '/',
        component: Dashboard,
        props: true
    },
    { path: '*', redirect: '/' }
];


//----------registrations
import RegistrationsList from "./registrations/List";
import RegistrationsCreate from "./registrations/Create";
import RegistrationsViewEdit from "./registrations/ViewEdit";

const routes_registrations =     {
    path: '/registrations',
    component: RegistrationsList,
    props: true,
    children: [
        {
            path: 'create',
            component: RegistrationsCreate,
            props: true,
        },
        {
            path: 'view/:id',
            component: RegistrationsViewEdit,
            props: true
        }
    ]
};
routes.push(routes_registrations);
//----------/registrations

//----------users
import UsersList from "./users/List";
import UsersCreate from "./users/Create";
import UsersViewEdit from "./users/ViewEdit";
import UsersRoles from "./users/Roles";

const routes_users =     {
    path: '/users',
    component: UsersList,
    props: true,
    children: [
        {
            path: 'create',
            component: UsersCreate,
            props: true
        },
        {
            path: 'view/:id',
            component: UsersViewEdit,
            props: true
        },
        {   path: 'roles/:id',
            component: UsersRoles,
            props: true
        },
    ]
};
routes.push(routes_users);
//----------/users



export default routes;