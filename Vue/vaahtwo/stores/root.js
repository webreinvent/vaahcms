import {defineStore, acceptHMRUpdate} from 'pinia';

export const useRootStore = defineStore({
    id: 'root',
    state: () => ({
        assets: null,
        gutter: 20,
        show_progress_bar: false,
    }),
    getters: {},
    actions: {
        async getAssets() {
            /*let res  = await axios.get('https://gorest.co.in/public/v2/users');
              this.assets = res.data;
              return res.data;*/
        },
        async to(path)
        {
            this.$router.push({path: path})
        },
        showProgress()
        {
            this.show_progress_bar = true;
        },
        hideProgress()
        {
            this.show_progress_bar = false;
        }

    }
})


// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRootStore, import.meta.hot))
}
