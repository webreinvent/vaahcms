import TableTrView from '../../../vaahvue/reusable/TableTrView.vue'

let namespace = 'media';
export default {
    computed: {
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        query_string() {return this.$store.getters[namespace+'/state'].query_string},
    },
    components:{
        TableTrView,
    },

    data()
    {
        let obj = {

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
        setActiveItem: function (item,route_name = 'media.view') {
            this.update('active_item', item);
            this.$router.push({name: route_name, params:{id:item.id}})
        },
        //---------------------------------------------------------------------
        hasPermission: function(slug)
        {
            return this.$vaah.hasPermission(this.permissions, slug);
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
