import Dashboard from "./dashboard/Dashboard";
import RegistrationsList from "./registrations/List";

const routes= [
    {   path: '/',
        props: {assets: true},
        component: Dashboard
    },
    {   path: '/registrations',
        props: {assets: true},
        component: RegistrationsList
    },
    { path: '*', redirect: '/' }
];

export default routes;