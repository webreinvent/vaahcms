export default async function GetAssets ({ to, from, next, store }){
    let root_assets = store.getters['root/state'];

    let payload = {
        params:{},
        query: {}
    };


    payload.params.get_server_details = true;
    if(!root_assets.auth_user)
    {
        payload.params.get_auth_user = true;
    }

    if(!root_assets.auth_user)
    {
        payload.params.get_auth_user = true;
    }


    if( Object.keys(payload.params).length > 0)
    {
        //await store.dispatch('root/getAssets', payload);
    }


    return next()
}
