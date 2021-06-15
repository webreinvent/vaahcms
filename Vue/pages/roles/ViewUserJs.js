import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'
import ButtonMeta from '../../vaahvue/reusable/ButtonMeta'
import {ModalProgrammatic as Modal} from "buefy";

let namespace = 'roles';

export default {
    props: ['id'],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        item() {return this.$store.getters[namespace+'/state'].active_item},
    },
    components:{
        ...GlobalComponents,
        ButtonMeta,
    },
    data()
    {
        return {
            is_btn_loading: false,
            is_content_loading: false,
            items: null,
            filter: {
                page: 1
            },
            search_item:null,
            search_delay_time: 800,
        }
    },
    watch: {
        $route(to, from) {
            this.updateView();
            this.getItemUsers();
        }
    },
    mounted() {
        //----------------------------------------------------
        this.onLoad();
        //----------------------------------------------------
        this.is_content_loading = true;
        //----------------------------------------------------
        //----------------------------------------------------
    },
    methods: {
        //---------------------------------------------------------------------
        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        updateView: function()
        {
            this.$store.dispatch(namespace+'/updateView', this.$route);
        },
        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.updateView();
            this.getAssets();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
            this.getItemUsers();
        },
        //---------------------------------------------------------------------
        getItemUsers: function (page = 1) {

            this.filter.page = page;

            this.$Progress.start();
            this.params = {
                q:this.search_item,
                page:page
            };

            let url = this.ajax_url+'/item/'+this.id+'/users';
            this.$vaah.ajaxGet(url, this.params, this.getItemUsersAfter);
        },
        //---------------------------------------------------------------------
        getItemUsersAfter: function (data, res) {

            this.$Progress.finish();
            this.is_content_loading = false;

            if(data)
            {
                this.items = data;
                this.update('active_item', data.item);
            } else
            {
                //if item does not exist or delete then redirect to list
                this.update('active_item', null);
                this.$router.push({name: 'role.list'});
            }

        },
        //---------------------------------------------------------------------
        changePermission: function (item) {

            let params = {
                id : this.id,
                user_id : item.id,
                query_string : this.page.query_string,
            };

            var data = {};

            if(item.pivot.is_active)
            {
                data.is_active = 0;
            } else
            {
                data.is_active = 1;
            }

            this.actions(false, 'toggle_user_active_status', params, data)

        },

        //---------------------------------------------------------------------
        actions: function (e, action, inputs, data) {
            if(e)
            {
                e.preventDefault();
            }

            var url = this.ajax_url+"/actions/"+action;
            var params = {
                inputs: inputs,
                data: data,
            };

            this.$vaah.ajax(url, params, this.actionsAfter);
        },
        //---------------------------------------------------------------------
        actionsAfter: function (data,res) {
            this.getItemUsers(this.filter.page);
            this.update('is_list_loading', false);
            this.$emit('eReloadList');
            this.$store.dispatch('root/reloadPermissions');
        },
        //---------------------------------------------------------------------
        delayedSearch: function()
        {
            this.$Progress.start();
            let self = this;
            clearTimeout(this.search_delay);
            this.search_delay = setTimeout(function() {
                self.getItemUsers();
            }, this.search_delay_time);

            // this.query_string.page = 1;
            // this.update('query_string', this.query_string);

        },
        //---------------------------------------------------------------------
        resetActiveItem: function () {
            this.update('active_item', null);
            this.$router.push({name:'role.list'});
        },
        //---------------------------------------------------------------------
        bulkActions: function (input) {
            let params = {
                id : this.id,
                user_id : null
            };

            var data = {
                is_active: input
            };

            this.actions(false, 'toggle_user_active_status', params, data)

        },
        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
        //---------------------------------------------------------------------
        showModal: function (item) {

            let json_content = `<div class="card">
                                    <div class='card-header'> 
                                                <div class="card-header-title 
                                                            has-text-primary"> 
                                                  Detail 
                                                </div> 
                                              </div> 
                                              <div class="card-content"> 
                                                <table class="table">
                                           
                                                <tbody>`;



            $.each(item.json, function( index, value ) {
                json_content += `<tr>
                                    <th>`+index+`</th>
                                    <td>:</td>
                                      <td>`+value+`</td>
                                      </tr>`;
            });


            json_content += `</tbody>
                            </table>

                            </div>
                            </div>`;

            let props ={
                width: 640,

                scroll: 'keep',
                content:  json_content,
            };

            Modal.open(props);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
