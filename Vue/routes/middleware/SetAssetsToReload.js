
export default async function SetAssetsToReload ({ to, from, next, store }){

    /*
    * Root will be reset to delete old and and fresh fetching of assets
    */

    let payload = {
        key: 'assets_reload',
        value: true,
    };
    store.commit('root/updateState', payload);

    return next()
}
