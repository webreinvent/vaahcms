import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';

let namespace = 'backups';

export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
    },
    components:{
        ...GlobalComponents,
    },
    data()
    {
        let obj = {
            assets:null,
            list: null,
            show_backup_form: true,
            include:{
                database: false,
                media: false,
            }
        };

        return obj;
    },
    watch: {


    },
    mounted() {


        //---------------------------------------------------------------------

        //---------------------------------------------------------------------

        //---------------------------------------------------------------------

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
        toggleForm: function()
        {


            if(this.show_backup_form)
            {
                this.show_backup_form = false;
            } else
            {
                this.show_backup_form = true;
            }

        },
        //---------------------------------------------------------------------
        createBackup: function () {
            this.$Progress.start();
            let params = {};
            let url = this.ajax_url+'/create';
            this.$vaah.ajax(url, params, this.createBackupAfter);
        },
        //---------------------------------------------------------------------
        takeBackupAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                this.update('list', data.list);
            }

        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
