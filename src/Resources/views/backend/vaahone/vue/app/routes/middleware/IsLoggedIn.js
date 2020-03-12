import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";

export default async function IsLoggedIn ({ to, from, next, store }){

    let payload;

    if(!store.getters['root/state'].check_logged_in){
        let url = store.getters['root/state'].json_url+'/is-logged-in';
        let data = await Vaah.ajax(url, {});

        payload = {
            key: 'is_logged_in',
            value: data.data.data.is_logged_in
        };
        store.commit('root/updateState', payload);

        if(data.data.data.is_logged_in)
        {
            payload = {
                key: 'check_logged_in',
                value: true
            };

        } else
        {
            payload = {
                key: 'check_logged_in',
                value: false
            };
        }

        store.commit('root/updateState', payload);

    }

    //--------------Redirect to Sign in
    if(!store.getters['root/state'].is_logged_in){
        return next({
            name: 'sign.in'
        })
    }
    //--------------/Redirect to Sign in

    return next()
}
