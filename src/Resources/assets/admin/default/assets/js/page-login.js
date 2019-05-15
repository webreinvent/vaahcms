//#########################Vue#################################################
const app = new VueCommon({
    el: '#app',
    data: {
        urls: [],
        credentials: {
            email: null,
            password: null,
        },
    },
    mounted: function () {
        //---------------------------------------------------------------
        this.urls.current = window.location.href;
        //---------------------------------------------------------------
        //---------------------------------------------------------------
        //---------------------------------------------------------------
    },
    methods:{
        //---------------------------------------------------------------------
        postLogin: function (e) {
            if(e)
            {
                e.preventDefault();
            }
            var url = this.urls.current+"/post";
            var params = this.credentials;
            this.processHttpRequest(url, params, this.postLoginAfter);
        },
        //---------------------------------------------------------------------
        postLoginAfter: function (data) {

            window.location = data.redirect_url;

            this.stopNprogress();
        },
        //---------------------------------------------------------------------
        //---------------------------------------------------------------------
    }
});