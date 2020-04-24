import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";
export default async function GetBackendAssets ({ to, from, next, store }){

    //--------------Redirect to Sign in
    if(!store.getters['root/state'].is_logged_in){
        return next({
            name: 'sign.in'
        })
    }
    //--------------/Redirect to Sign in

    let assets = store.getters['root/state'].assets;
    console.log('--->', assets);

    if(assets && !assets.auth_user)
    {
        await store.dispatch('root/reloadAssets');
        await store.dispatch('root/reloadPermissions');
    } else
    {
        await store.dispatch('root/getAssets');
        await store.dispatch('root/getPermissions');
    }






    return next()
}
