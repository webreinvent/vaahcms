import Dashboard from "./dashboard/Dashboard";
import RegistrationsList from "./registrations/List";
import RegistrationsCreate from "./registrations/Create";

//---------Variables
var base_url = $('base').attr('href');
var current_url = $('#current_url').attr('content');
var debug = $('#debug').attr('content');
//---------/Variables

let urls = {
    base: base_url,
    current: current_url,
};

console.log("urls", urls);

const routes= [
    {   path: '/',
        component: Dashboard
    },
    {   path: '/registrations',
        component: RegistrationsList
    },
    {   path: '/registrations/create',
        component: RegistrationsCreate
    },
    { path: '*', redirect: '/' }
];

export default routes;