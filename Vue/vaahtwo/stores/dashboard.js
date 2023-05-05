import {defineStore, acceptHMRUpdate} from 'pinia';
import {vaah} from '../vaahvue/pinia/vaah'
import {useAuthStore} from "./auth";
import {useRootStore} from "./root";

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url;
let json_url = ajax_url + "/json";

export const useDashboardStore = defineStore({
    id: 'dashboard',
    state: () => ({
        title: 'Dashboard',
        active_index: [0,1],
        ajax_url: ajax_url,
        assets_is_fetching: true,
        dashboard_items: null,
        json_url: json_url,
    }),

    getters: {},
    actions: {
        async getItem() {
            if (this.assets_is_fetching === true) {
                this.assets_is_fetching = false;

                let params = {
                };

                vaah().ajax(
                    this.ajax_url+'/dashboard/getItem',
                    this.afterGetItem,
                    params
                );
            }
        },
        //-----------------------------------------------------------------------
        afterGetItem(data, res) {
            if (data) {
                this.dashboard_items = data.item;
            }
        },
        //-----------------------------------------------------------------------
        goToLink (link, target = false) {

            if(!link) {
                return false;
            }

            if(target) {
                window.open(link, '_blank');
            } else {
                window.location.href = link;
            }
        },
        //-----------------------------------------------------------------------
        async to(path)
        {
            this.$router.push({path: path})
        },
        //---------------------------------------------------------------------
        showProgress()
        {
            this.show_progress_bar = true;
        },
        //---------------------------------------------------------------------
        hideProgress()
        {
            this.show_progress_bar = false;
        },
        //---------------------------------------------------------------------
        hasPermission(slug) {
            const root = useRootStore();
            return vaah().hasPermission(root.permissions, slug);
        },
        //---------------------------------------------------------------------
        setTitle() {
            if (this.title) {
                document.title = this.title;
            }
        }
        //---------------------------------------------------------------------
    }
})

// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useAuthStore, import.meta.hot))
}
