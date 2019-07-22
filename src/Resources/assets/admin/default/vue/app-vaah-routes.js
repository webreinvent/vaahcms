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


//----------roles
import RolesList from "./roles/List";
import RolesCreate from "./roles/Create";
import RolesViewEdit from "./roles/ViewEdit";
import RolesPermissions from "./roles/Permissions";
import RolesUsers from "./roles/Users";

const routes_roles =     {
    path: '/roles',
    component: RolesList,
    props: true,
    children: [
        {
            path: 'create',
            component: RolesCreate,
            props: true
        },
        {
            path: 'view/:id',
            component: RolesViewEdit,
            props: true
        },
        {
            path: 'permissions/:id',
            component: RolesPermissions,
            props: true
        },
        {
            path: 'users/:id',
            component: RolesUsers,
            props: true
        },
    ]
};
routes.push(routes_roles);
//----------/roles


//----------permissions
import PermissionsList from "./permissions/List";
import PermissionsViewEdit from "./permissions/ViewEdit";
import PermissionsRoles from "./permissions/Roles";

const routes_permissions =     {
    path: '/permissions',
    component: PermissionsList,
    props: true,
    children: [
        {
            path: 'view/:id',
            component: PermissionsViewEdit,
            props: true
        },
        {
            path: 'roles/:id',
            component: PermissionsRoles,
            props: true
        },
    ]
};
routes.push(routes_permissions);
//----------/permissions

//----------modules
import ModulesList from "./modules/List";
import ModulesAdd from "./modules/Add";

const routes_modules =     {
    path: '/modules',
    component: ModulesList,
    props: true,
    children: [
        {
            path: 'add',
            component: ModulesAdd,
            props: true
        },
    ]
};
routes.push(routes_modules);
//----------/modules


//----------themes
import ThemesList from "./themes/List";
import ThemesAdd from "./themes/Add";

const routes_themes =     {
    path: '/themes',
    component: ThemesList,
    props: true,
    children: [
        {
            path: 'add',
            component: ThemesAdd,
            props: true
        },
    ]
};
routes.push(routes_themes);
//----------/themes


export default routes;