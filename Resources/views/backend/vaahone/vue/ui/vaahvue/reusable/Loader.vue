<template>
    <div>
        <div style="max-width:300px; max-height: 60px;">
            <content-loader
                    :height="50"
                    :width="300"
                    :speed="1"
                    primaryColor="#f3f3f3"
                    secondaryColor="#ecebeb"
            >
                <rect x="25" y="10" rx="5" ry="5" width="30%" height="5" />
                <rect x="25" y="20" rx="5" ry="5" width="50%" height="5" />
                <rect x="25" y="30" rx="5" ry="5" width="80%" height="5" />

            </content-loader>
        </div>
    </div>
</template>

<script>

    import { ContentLoader } from "vue-content-loader";

    export default {
        name: "Loader",
        components:{
            ContentLoader,
        },
        data()
        {
            let obj = {

            };

            return obj;
        },

        created() {

        },
        watch: {

        },
        methods: {

            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        },
    }
</script>

