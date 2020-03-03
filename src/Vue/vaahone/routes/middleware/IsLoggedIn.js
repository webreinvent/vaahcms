export default async function IsLoggedIn ({ to, from, next, store }){

    if(!store.getters['root/state'].check_logged_in){
        await store.dispatch('root/checkIsLoggedIn');
    }

    if(!store.getters['root/state'].is_logged_in){
        return next('/')
    }

    return next()
}
