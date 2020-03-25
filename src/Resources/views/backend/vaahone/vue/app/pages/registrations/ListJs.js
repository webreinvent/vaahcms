import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'

let namespace = 'registrations';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        query_string() {return this.$store.getters[namespace+'/state'].query_string},
    },
    components:{
        ...GlobalComponents,

    },
    data()
    {
        return {
            is_content_loading: false,
            assets: null,
            is_btn_loading: false,
        }
    },
    watch: {

    },
    mounted() {
        //----------------------------------------------------
        this.updateQueryString();
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
        updateQueryString: function()
        {
            let query = this.$vaah.removeEmpty(this.$route.query);
            if(Object.keys(query).length)
            {
                for(let key in query)
                {
                    this.query_string[key] = query[key];
                }
            }
            this.update('query_string', this.query_string);
            this.$vaah.updateCurrentURL(this.query_string, this.$router);

            this.getAssets();
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');

            this.getList();
        },
        //---------------------------------------------------------------------
        paginate: function(page=1)
        {
            this.query_string.page = page;
            this.update('query_string', this.query_string);
            this.getList();
        },
        //---------------------------------------------------------------------
        delayedSearch: function()
        {
            let timeout = null;
            clearTimeout(timeout);
            // Make a new timeout set to go off in 800ms
            timeout = setTimeout(() => {
                this.getList();
            }, 800);
        },
        //---------------------------------------------------------------------
        getList: function () {
            this.$vaah.updateCurrentURL(this.query_string, this.$router);
            let url = this.ajax_url+'/list';
            this.$vaah.ajax(url, this.query_string, this.getListAfter);
        },
        //---------------------------------------------------------------------
        getListAfter: function (data, res) {

            console.log('--->', data);

            this.update('is_list_loading', false);
            this.update('list', data.list);

            if(data.list.total === 0)
            {
                this.update('list_is_empty', true);
            }

        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
