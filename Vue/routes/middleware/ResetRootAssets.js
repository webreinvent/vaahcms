
export default async function ResetRootAssets ({ to, from, next, store }){

    /*
    * Root will be reset to delete old and and fresh fetching of assets
    */

    let payload = {
        key: 'assets',
        value: null,
    };
    store.commit('root/updateState', payload);

    return next()
}
