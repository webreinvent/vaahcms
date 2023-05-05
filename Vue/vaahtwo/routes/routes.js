let routes= [];

import ui from "./vue-routes-ui";
import public_routes from "./vue-routes-public";
import dashboard from "./vue-routes-dashboard";
import users from "./vue-routes-users";
import roles from "./vue-routes-roles";
import advanced from "./vue-routes-advanced";
import permissions from "./vue-routes-permissions";
import settings from "./vue-routes-settings";
import registrations from "./vue-routes-registrations";
import media from "./vue-routes-media";
import taxonomies from "./vue-routes-taxonomies";
import modules from "./vue-routes-modules";
import themes from "./vue-routes-themes";
import profile from "./vue-routes-profile";

routes = routes.concat(ui);
routes = routes.concat(public_routes);
routes = routes.concat(dashboard);
routes = routes.concat(roles);
routes = routes.concat(advanced);
routes = routes.concat(users);
routes = routes.concat(permissions);
routes = routes.concat(settings);
routes = routes.concat(registrations);
routes = routes.concat(media);
routes = routes.concat(taxonomies);
routes = routes.concat(modules);
routes = routes.concat(themes);
routes = routes.concat(profile);

export default routes;
