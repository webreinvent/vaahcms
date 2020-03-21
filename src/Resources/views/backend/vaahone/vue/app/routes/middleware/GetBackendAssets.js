import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";

export default async function GetBackendAssets ({ to, from, next, store }){

    //--------------Redirect to Sign in
    if(!store.getters['root/state'].is_logged_in){
        return next({
            name: 'sign.in'
        })
    }
    //--------------/Redirect to Sign in


    let root_assets = store.getters['root/state'].assets;

    let params = {};


    if(!root_assets || (root_assets && !root_assets.server))
    {
        params.get_server_details = true;
    }

    if(!root_assets || (root_assets && !root_assets.auth_user))
    {
        params.get_auth_user = true;
    }

    if(!root_assets || (root_assets && !root_assets.extended_views))
    {
        params.get_extended_views = true;
    }

    if( Object.keys(params).length > 0)
    {

        let url = store.getters['root/state'].json_url+'/assets';
        let data = await Vaah.ajax(url, params);

        if(!root_assets)
        {
            root_assets = {};
        }

        for(let index in data.data.data)
        {
            root_assets[index] = data.data.data[index];
        }

        let payload = {
            key: 'assets',
            value: root_assets
        };

        store.commit('root/updateState', payload);

    }


    return next()
}
