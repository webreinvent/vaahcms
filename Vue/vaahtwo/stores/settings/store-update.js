import { watch,nextTick  } from 'vue'
import { acceptHMRUpdate, defineStore } from 'pinia'
import qs from 'qs'
import countriesData from "../../assets/data/country.json";
import { useRootStore } from "../root.js";
import { vaah } from '../../vaahvue/pinia/vaah'
import semver from "semver";
// import Terminal from "primevue/terminal";
//----Terminal
import 'xterm/css/xterm.css'
import { Terminal } from 'xterm'
import { FitAddon } from 'xterm-addon-fit'
import { WebLinksAddon } from 'xterm-addon-web-links'
import { Unicode11Addon } from 'xterm-addon-unicode11'
//----/Terminal
let model_namespace = 'WebReinvent\\VaahCms\\Models\\Setting';

let base_url = document.getElementsByTagName('base')[0].getAttribute("href");
let ajax_url = base_url + "/vaah/settings/update";

export const useUpdateStore = defineStore({
    id: 'update',
    state: () => ({
        title: 'Update - Settings',
        base_url: base_url,
        ajax_url: ajax_url,
        model: model_namespace,
        assets_is_fetching: true,
        app: null,
        activeSubTab: 0,
        fillable: null,
        route: null,
        view: 'large',
        show_filters: false,
        list_view_width: 12,
        search: {
            delay_time: 600, // time delay in milliseconds
            delay_timer: 0 // time delay in milliseconds
        },
        form: {
            type: 'Create',
            action: null,
            is_button_loading: null
        },
        is_list_loading: null,
        count_filters: 0,
        list_selected_menu: [],
        list_bulk_menu: [],
        item_menu_list: [],
        item_menu_state: null,
        form_menu_list: [],
        name: null,
        update:false,
        labelPosition: 'on-border',
        update_available: false,
        manual_update: false,
        backup_database: false,
        backend_update: false,
        release: null,
        remote_version: null,
        is_button_active:false,
        is_up_to_data:false,
        is_update_step_visible: false,
        status: {
            download_latest_version: null,
            publish_assets: null,
            migration_and_seeds: null,
            clear_cache: null,
            page_refresh: null,
        },
    }),
    getters: {},
    actions: {
        //---------------------------------------------------------------------
        async checkForUpdate() {
           let url = 'https://api.github.com/repos/webreinvent/vaahcms/releases/latest';
           await vaah().ajax(
               url,
               this.checkForUpdateAfter,
           );
        },
        //---------------------------------------------------------------------
        checkForUpdateAfter: function (data, res) {
            this.update_available=false;
            this.manual_update=false;
            this.backend_update=false;
            const root = useRootStore();

            if(!res || !res.data || !res.data.tag_name)
            {
                vaah().toastErrors(['Something went wrong.']);
                return false;
            }

            this.release = res.data;

            let local = semver.clean(root.assets.vaahcms.version);
            this.remote_version = semver.clean(res.data.tag_name);

            let diff = semver.diff(this.remote_version, local );

            this.is_up_to_data= false;

            if(diff){
                this.update_available=true;
                if(diff === 'major'){
                    this.manual_update=true;
                }else{
                    this.backend_update=true;

                }
            }else{
                this.is_up_to_data= true;
            }

            this.storeUpdateCheck();

        },
        //---------------------------------------------------------------------
        async storeUpdateCheck () {
            let options = {
                method:'post',
                params:{
                    remote_version: this.remote_version,
                    update_available: this.update_available,
                    manual_update: this.manual_update,
                }
            };
            await vaah().ajax(
                this.ajax_url+'/store',
                null,
                options);
        },
        //---------------------------------------------------------------------
        async onUpdate(){
            this.is_checkbox_active = false;
            this.is_button_active = false;
            this.is_update_step_visible = true;
            this.status.download_latest_version = 'pending';

            let self = this;

            await nextTick(() => {
                self.term = new Terminal({convertEol: true,allowProposedApi: true})
                self.fitAddon = new FitAddon()
                self.unicode11Addon = new Unicode11Addon()
                self.WebLinksAddon = new WebLinksAddon()
                self.term.loadAddon(this.fitAddon)
                self.term.loadAddon(this.WebLinksAddon)
                self.term.loadAddon(this.unicode11Addon)
                self.term.unicode.activeVersion = '11'
                self.term.open(document.getElementById('terminal'));
                self.fitAddon.fit();


                self.term.writeln('Step 1/4 : Updating dependencies');
                self.term.writeln('-----------------------------------------');
                self.term.writeln('composer update');

                vaah().ajax(
                    this.ajax_url + '/upgrade',
                    this.onUpdateAfter,
                );
            });
        },
        //---------------------------------------------------------------------
        onUpdateAfter(data, res) {
            if(res && res.data && res.data.status){
                this.status.download_latest_version = res.data.status;

                if(data.output)
                {
                    this.term.writeln(data.output);
                }

                if(res.data.status === 'success'){

                    if(!data){
                        this.status.download_latest_version = 'failed';
                        vaah().toastErrors(['Go to Root path','Run <b>Composer Update</b>']);
                        return false;
                    }


                    this.term.writeln('\nStep 2/4 : Public Publishable Assets');
                    this.term.writeln('-----------------------------------------');
                    this.term.writeln("\nphp artisan vendor:publish --provider=\"WebReinvent\\VaahCms\\VaahCmsServiceProvider\" --tag=assets --force");

                    this.term.writeln("\nphp artisan vendor:publish --provider=\"WebReinvent\\VaahCms\\VaahCmsServiceProvider\" --tag=migrations  --force");

                    this.term.writeln("\nphp artisan vendor:publish --provider=\"WebReinvent\\VaahCms\\VaahCmsServiceProvider\" --tag=migrations  --force");

                    this.term.writeln("\nphp artisan vendor:publish --provider=\"WebReinvent\\VaahCms\\VaahCmsServiceProvider\" --tag=seeds --force");

                    this.status.publish_assets = 'pending';
                    vaah().ajax(
                        this.ajax_url + '/publish',
                        this.onPublishAfter,
                    );
                }else{
                    this.status.download_latest_version = 'failed';
                }
            }


        },
        //---------------------------------------------------------------------
        onPublishAfter(data, res) {
            if(res && res.data && res.data.success){


                if(res.data.success === true){
                    this.status.publish_assets = 'success';
                    this.term.writeln('\nStep 3/4 : Running migrations & Seeds');
                    this.term.writeln('-----------------------------------------');
                    this.term.writeln("php artisan migrate");
                    this.term.writeln("php artisan db:seed");

                    this.status.migration_and_seeds = 'pending';
                    vaah().ajax(
                        this.ajax_url + '/run/migrations',
                        this.onMigrationAndSeedsAfter,
                    );
                }else{
                    this.status.publish_assets = 'failed';
                }

            }
        },
        //---------------------------------------------------------------------
        onMigrationAndSeedsAfter(data, res) {
            if(res && res.data && res.data.success){


                if(res.data.success === true){
                    this.status.migration_and_seeds = 'success';
                    this.term.writeln('\nStep 4/4 : Clear Cache');
                    this.term.writeln('-----------------------------------------');
                    this.term.writeln("php artisan cache:clear");
                    this.term.writeln("php artisan route:clear");
                    this.term.writeln("php artisan config:clear");
                    this.term.writeln("php artisan view:clear \n");
                    this.term.writeln('\u001b[32m' +"-----------------------------------------------------");
                    this.term.writeln(" Update was successful! Click on Reload button.");
                    this.term.writeln("-----------------------------------------------------");

                    this.status.clear_cache = 'pending';
                    vaah().ajax(
                        this.ajax_url + '/cache',
                        this.onClearCacheAfter,
                    );
                }else{
                    this.status.migration_and_seeds = 'failed';
                }

            }
        },
        //---------------------------------------------------------------------
        onClearCacheAfter (data, res) {
            if(res && res.data && res.data.status){
                this.status.clear_cache = res.data.status;

                if(res.data.status === 'success'){
                    this.status.page_refresh = 'pending';
                    //location.reload();
                }else{
                    this.status.clear_cache = 'failed';
                }
            }
        },
        //---------------------------------------------------------------------
        reloadPage()
        {
            location.reload();
        },
        //---------------------------------------------------------------------
        setPageTitle() {
            if (this.title) {
                document.title = this.title;
            }
        }

    }
});



// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUpdateStore, import.meta.hot))
}
