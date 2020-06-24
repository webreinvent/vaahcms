import Logo from '../../components/Logo';
import Footer from '../../components/Footer';


export default {
    computed:{
        root() {return this.$store.getters['root/state']},
        ajax_url() {return this.$store.getters['root/state'].ajax_url},
    },
    components:{
        Logo,
        Footer,
    },
    data()
    {
        return {
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

    },
    methods: {
        //---------------------------------------------------------------------
        signIn: function () {

            this.is_btn_loading = true;
            let params = this.credentials;
            let url = this.ajax_url+'/signin/post';
            this.$vaah.ajax(url, params, this.signInAfter);

        },
        //---------------------------------------------------------------------
        signInAfter: function (data, res) {
            this.is_btn_loading = false;
            if(data)
            {
                console.log('--->', data);
            }
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
}
