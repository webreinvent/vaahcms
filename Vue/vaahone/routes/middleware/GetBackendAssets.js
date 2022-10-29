import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";
export default async function GetBackendAssets ({ to, from, next, store }){

    //--------------Redirect to Sign in
    if(!store.getters['root/state'].is_logged_in){
        return next({
            name: 'sign.in'
        })
    }
    //--------------/Redirect to Sign in

    await store.dispatch('root/getAssets');

    await store.dispatch('root/getPermissions');


    return next()
}
