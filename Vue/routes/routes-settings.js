//----------Middleware
import IsLoggedIn from './middleware/IsLoggedIn'
import GetBackendAssets from './middleware/GetBackendAssets'
//----------Middleware

//----------Layout
import LayoutBackend from "./../layouts/Backend";
//----------Layout

let routes=[];

import SettingsLayout from "./../pages/settings/SettingsLayout";
import GeneralIndex from "./../pages/settings/general/Index";
import LocalizationIndex from "./../pages/settings/localization/Index";
import EnvIndex from "./../pages/settings/env/Index";
import NotificationsIndex from "./../pages/settings/notifications/Index";
import BackupsIndex from "./../pages/settings/backups/Index";

let list =     {
    path: '/vaah/',
    component: LayoutBackend,
    props: true,
    meta: {
        middleware: [
            IsLoggedIn,
            GetBackendAssets
        ]
    },
    children: [
        {
            path: 'settings',
            component: SettingsLayout,
            props: true,
            meta: {
                middleware: [
                    IsLoggedIn,
                    GetBackendAssets
                ]
            },
            children: [
                {
                    path: 'general',
                    name: 'general.index',
                    component: GeneralIndex,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },
                {
                    path: 'env-variables',
                    name: 'env.index',
                    component: EnvIndex,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },
                {
                    path: 'localization',
                    name: 'localization.index',
                    component: LocalizationIndex,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },
                {
                    path: 'notifications',
                    name: 'notifications.index',
                    component: NotificationsIndex,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },
                {
                    path: 'backups',
                    name: 'backups.index',
                    component: BackupsIndex,
                    props: true,
                    meta: {
                        middleware: [
                            IsLoggedIn,
                            GetBackendAssets
                        ]
                    }
                },

            ]
        }

    ]
};


routes.push(list);

export default routes;
