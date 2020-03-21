import GlobalComponents from '../../vaahvue/helpers/GlobalComponents'

let namespace = 'registrations';

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        page() {return this.$store.getters[namespace+'/state']},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
    },
    components:{
        ...GlobalComponents,

    },
    data()
    {
        return {
            is_content_loading: false,
            assets: null,
            data: [
                { 'id': 1, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Simmons', 'categories': 'XYZ, ABC', 'tag_data': 'Male', 'date': '5 April, 2020' },
                { 'id': 2, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Jacobs', 'categories': 'XYZ, ABC', 'tag_data': 'Male', 'date': '5 April, 2020' },
                { 'id': 3, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Gilbert', 'categories': 'XYZ, ABC', 'tag_data': 'Female', 'date': '5 April, 2020' },
                { 'id': 4, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Flores', 'categories': 'XYZ, ABC', 'tag_data': 'Male', 'date': '5 April, 2020' },
                { 'id': 5, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Lee', 'categories': 'XYZ, ABC', 'tag_data': 'Female', 'date': '5 April, 2020' }
            ],
            checkboxPosition: 'left',
            columns: [
                {
                    field: 'id',
                    label: 'ID',
                    width: '40',
                    numeric: true
                },
                {
                    field: 'title',
                    label: 'Title',
                },
                {
                    field: 'author',
                    label: 'Author',
                },
                {
                    field: 'categories',
                    label: 'Categories',
                    centered: true
                },
                {
                    field: 'tag_data',
                    label: 'Tags',
                },
                {
                    field: 'date',
                    label: 'Date',
                }
            ],
            is_btn_loading: false,
            credentials: {
                email: null,
                password: null
            }
        }
    },
    watch: {

    },
    mounted() {
        //----------------------------------------------------
        this.getAssets();
        this.getList();
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
        async getAssets() {
            await this.$store.dispatch(namespace+'/getAssets');
        },
        //---------------------------------------------------------------------
        getList: function () {
            let params = {};
            let url = this.ajax_url+'/list';
            this.$vaah.ajax(url, params, this.getListAfter);
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
