import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";

export default async function IsLoggedIn ({ to, from, next, store }){

    /*if(!store.getters['root/state'].check_logged_in){
        let url = store.getters['root/state'].json_url+'/is-logged-in';
        let data = await Vaah.ajax(url, {});

        let payload = {
            key: 'is_logged_in',
            value: data.data.data.is_logged_in
        };
        store.commit('root/updateState', payload);

        if(data.data.data.is_logged_in)
        {
            let payload = {
                key: 'check_logged_in',
                value: true
            };
            store.commit('root/updateState', payload);
        }

    }

    if(!store.getters['root/state'].is_logged_in){
        return next({
            name: 'sign.in'
        })
    }*/

    return next()
}
