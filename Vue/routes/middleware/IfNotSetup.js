import {VaahHelper as Vaah} from "../../vaahvue/helpers/VaahHelper";

export default async function IfNotSetup ({ to, from, next, store }){

    let params = {};

    let url = store.getters['setup/state'].ajax_url+'/status';

    let data = await Vaah.ajax(url, params);

    let payload = {
        key: 'status',
        value: data.data.data
    };

    store.commit('root/updateState', payload);

    if(data.data.data.stage != 'installed')
    {
        return next({
            name: 'setup.index'
        })
    }

    return next()
}
