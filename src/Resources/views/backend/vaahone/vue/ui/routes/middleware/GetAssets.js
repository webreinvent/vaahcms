import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";

export default async function GetAssets ({ to, from, next, store }){

    /*let root_assets = store.getters['root/state'].assets;

    console.log('--->', root_assets);

    let params = {};

    params.get_server_details = true;
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

        let payload = {
            key: 'assets',
            value: data.data.data
        };
        store.commit('root/updateState', payload);

    }*/


    return next()
}
