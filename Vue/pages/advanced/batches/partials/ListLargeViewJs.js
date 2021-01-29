import ButtonMeta from '../../../../vaahvue/reusable/ButtonMeta';
import {ModalProgrammatic as Modal} from 'buefy';

let namespace = 'batches';

export default {
    computed: {
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        query_string() {return this.$store.getters[namespace+'/state'].query_string},
    },
    components:{
        ButtonMeta,
    },

    data()
    {
        let obj = {
            namespace: namespace,
            icon_copy: "<i class='fas fa-copy'></i>"
        };

        return obj;
    },
    created() {
    },
    mounted(){

    },

    watch: {

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
        setRowClass: function(row, index)
        {

            if(this.page.active_item && row.id == this.page.active_item.id)
            {
                return 'is-selected';
            }

            if(row.deleted_at != null)
            {
                return 'is-danger';
            }

        },
        //---------------------------------------------------------------------
        setActiveItem: function (item) {
            this.update('active_item', item);
            this.$router.push({name: 'batches.view', params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        changeStatus: function (id) {
            this.$Progress.start();
            let url = this.ajax_url+'/actions/bulk-change-status';
            let params = {
                inputs: [id],
                data: null
            };
            this.$vaah.ajax(url, params, this.changeStatusAfter);
        },
        //---------------------------------------------------------------------
        changeStatusAfter: function (data,res) {
            this.$emit('eReloadList');
            this.update('is_list_loading', false);

        },

        //---------------------------------------------------------------------
        copiedData: function (data) {

            this.$vaah.toastSuccess(['copied']);

        },
        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
        //---------------------------------------------------------------------
        deleteItem: function (item) {

            let url = this.ajax_url+'/actions/bulk-delete';

            let self = this;

            let id = null;

            if(item){
                id = item.id;
            }

            let params = {
                inputs: [id],
                data: this.page.bulk_action.data
            };

            this.$buefy.dialog.confirm({
                title: 'Deleting record',
                message: 'Are you sure you want to <b>delete</b> the record? This action cannot be undone.',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: function () {
                    self.$Progress.start();

                    self.$vaah.ajax(url, params, self.deleteItemAfter);
                }
            });



        },
        //---------------------------------------------------------------------
        deleteItemAfter: function (data, res) {

            if(data)
            {
                this.$emit('eReloadList');
            } else
            {
                this.$Progress.finish();
            }
        },
        //---------------------------------------------------------------------
        showModal: function (item) {

            let props ={
                width: 640,

                scroll: 'keep',
                content:  `<div class="card">
                                <div class='card-header'> 
                                            <div class="card-header-title 
                                                        has-text-primary"> 
                                              Detail 
                                            </div> 
                                          </div> 
                                          <div class="card-content"> 
                                            <table class="table">
                                       
                                            <tbody>
                                                <tr>
                                                <th>Total Jobs</th>
                                                <td>:</td>
                                                  <td>`+item.total_jobs+`</td>
                                                  </tr>
                                                  <tr>
                                                  <th>Pending Jobs</th>
                                                  <td>:</td>
                                                  <td>`+item.pending_jobs+`</td>
                                                  </tr>
                                                  <tr>
                                                   <th>Failed Jobs</th>
                                                   <td>:</td>
                                                  <td>`+item.failed_jobs+`</td>
                                                </tr>
                                                  <tr>
                                                   <th>Options</th>
                                                   <td>:</td>
                                                  <td>`+JSON.stringify(item.options, null, 2)+`</td>
                                                </tr>
                                            </tbody>
                                        </table>
  
                                        </div> 
                                        </div>`,
            };

            Modal.open(props);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
