import GlobalComponents from '../../../vaahvue/helpers/GlobalComponents';

import AutoComplete from '../../../vaahvue/reusable/AutoComplete.vue'
import AutoCompleteUsers from '../../../vaahvue/reusable/AutoCompleteUsers.vue'


let namespace = 'notifications';

export default {

    props: [],
    computed:{
        root() {return this.$store.getters['root/state']},
        permissions() {return this.$store.getters['root/state'].permissions},
        assets() {return this.$store.getters[namespace+'/state'].assets},
        ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
        active_item() {return this.$store.getters[namespace+'/state'].active_item},
        page() {return this.$store.getters[namespace+'/state']},
    },
    components:{
        ...GlobalComponents,
        AutoComplete,
        AutoCompleteUsers,
    },
    data()
    {
        let obj = {
            namespace:namespace,
            is_testing: false,
            send_to: null,
            is_sending: false,
            show_new_item_form: false,
            new_item: {
                name: null,
            },

        };

        return obj;
    },
    watch: {


    },
    mounted() {

        document.title = "Notifications";
        //---------------------------------------------------------------------
        this.onLoad();
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------

    },
    methods: {
        //---------------------------------------------------------------------

        //---------------------------------------------------------------------
        onLoad: function()
        {
            this.getAssets();
        },
        //---------------------------------------------------------------------
        update: function(name, value)
        {
            let update = {
                state_name: name,
                state_value: value,
                namespace: this.namespace,
            };
            this.$vaah.updateState(update);
        },
        //---------------------------------------------------------------------
        async getAssets() {
            await this.$store.dispatch(this.namespace+'/getAssets');
            //this.getList();
        },

        //---------------------------------------------------------------------
        setActiveItem: function(item)
        {
            this.update('active_item', item);
            this.fetchContent();
            this.setMailButton();
        },
        //---------------------------------------------------------------------
        create: function () {
            this.$Progress.start();
            let params = this.new_item;
            let url = this.ajax_url+'/create';
            this.$vaah.ajax(url, params, this.createAfter);
        },
        //---------------------------------------------------------------------
        createAfter: function (data, res) {
            this.$Progress.finish();
            if(data){

                this.new_item = {
                    name: null,
                };

                this.show_new_item_form = false;

                this.assets.notifications = data.list;
                this.update('assets', this.assets);
                this.update('active_item', data.item);
                this.fetchContent();
            }

        },
        //---------------------------------------------------------------------
        fetchContent: function () {
            this.$Progress.start();
            let params = this.active_item;
            let url = this.ajax_url+'/list';
            this.$vaah.ajax(url, params, this.fetchContentAfter);
        },
        //---------------------------------------------------------------------
        fetchContentAfter: function (data, res) {
            this.$Progress.finish();
            if(data){

                this.$set(this.active_item, 'contents', data.list);

                //this.active_item.contents = data.list;

                if(this.active_item.via_mail)
                {
                    if(data.list.mail.length < 1){
                        this.addMailContent();
                    }else{
                        this.setMailButton();
                    }


                }

                if(this.active_item.via_sms && data.list.sms.length < 1)
                {
                    this.addSmsContent();
                }

                if(this.active_item.via_push && data.list.push.length < 1)
                {
                    this.addPushContent();
                }


                if(this.active_item.via_backend && data.list.backend.length < 1)
                {
                    this.addBackendContent();
                }

                if(this.active_item.via_frontend && data.list.frontend.length < 1)
                {
                    this.addFrontendContent();
                }

                console.log('--->', this.active_item);
                console.log('--->', this.active_item);
                this.update('active_item', this.active_item);
            }
        },
        //---------------------------------------------------------------------
        addToMail: function (key) {
            let sort = 0;
            if(this.active_item.contents && this.active_item.contents.mail)
            {
                sort = this.active_item.contents.mail.length;
            }

            let line = {
                vh_notification_id: this.active_item.id,
                via: 'mail',
                sort: sort,
                key: key,
                value: null,
            }

            this.active_item.contents.mail.push(line);

            this.update('active_item', this.active_item);

            console.log('--->', this.active_item.contents);

        },
        //---------------------------------------------------------------------
        addSubject: function () {
            let sort = 0;
            if(this.active_item.contents && this.active_item.contents.mail)
            {
                sort = this.active_item.contents.mail.length;
            }

            let line = {
                vh_notification_id: this.active_item.id,
                via: 'mail',
                sort: sort,
                key: 'subject',
                value: null,
            };

            this.active_item.contents.mail.push(line);

            this.update('active_item', this.active_item);

            this.is_add_subject_disabled= true;


        },
        //---------------------------------------------------------------------
        addFrom: function () {
            let sort = 0;
            if(this.active_item.contents && this.active_item.contents.mail)
            {
                sort = this.active_item.contents.mail.length;
            }

            let line = {
                vh_notification_id: this.active_item.id,
                via: 'mail',
                sort: sort,
                key: 'from',
                value: this.assets.email,
                meta: {
                    name: null
                }
            };

            this.active_item.contents.mail.push(line);

            this.update('active_item', this.active_item);

            this.is_add_from_disabled= true;


        },
        //---------------------------------------------------------------------
        addAction: function () {
            let sort = 0;
            if(this.active_item.contents && this.active_item.contents.mail)
            {
                sort = this.active_item.contents.mail.length;
            }

            let line = {
                vh_notification_id: this.active_item.id,
                via: 'mail',
                sort: sort,
                key: 'action',
                value: null,
                meta: {
                    action: null
                }
            };

            this.active_item.contents.mail.push(line);

            this.update('active_item', this.active_item);

            console.log('--->', this.active_item.contents);

        },
        //---------------------------------------------------------------------
        addMailContent: function()
        {

            let lines = [
                {
                    vh_notification_id: this.active_item.id,
                    via: 'mail',
                    sort: 0,
                    key: 'subject',
                    value: null,
                }
            ];

            this.$set(this.active_item.contents, 'mail', lines);


            this.update('active_item', this.active_item);
            this.setMailButton();
        },
        //---------------------------------------------------------------------
        addSmsContent: function () {

            let contents = this.active_item.contents;

            let sms_lines = [
                {
                    vh_notification_id: this.active_item.id,
                    via: 'sms',
                    sort: 0,
                    key: 'content',
                    value: null,
                }
            ];

            this.$set(this.active_item.contents, 'sms', sms_lines);


            this.update('active_item', this.active_item);
        },
        //---------------------------------------------------------------------
        addPushContent: function () {

            let lines = [
                {
                    vh_notification_id: this.active_item.id,
                    via: 'push',
                    sort: 0,
                    key: 'content',
                    value: null,
                },
                {
                    vh_notification_id: this.active_item.id,
                    via: 'push',
                    sort: 1,
                    key: 'action',
                    value: null,
                    meta: {
                        action: null
                    }
                }
            ];

            this.$set(this.active_item.contents, 'push', lines);

            console.log('--->this.active_item.contents.push', this.active_item.contents.push);

            this.update('active_item', this.active_item);
        },
        //---------------------------------------------------------------------
        addBackendContent: function () {

            let contents = this.active_item.contents;

            let lines = [
                {
                    vh_notification_id: this.active_item.id,
                    via: 'backend',
                    sort: 0,
                    key: 'content',
                    value: null,
                },
                {
                    vh_notification_id: this.active_item.id,
                    via: 'backend',
                    sort: 1,
                    key: 'action',
                    value: null,
                    meta: {
                        action: null
                    }
                }
            ];

            this.$set(this.active_item.contents, 'backend', lines);

            this.update('active_item', this.active_item);

        },
        //---------------------------------------------------------------------
        addFrontendContent: function () {

            let contents = this.active_item.contents;

            let lines = [
                {
                    vh_notification_id: this.active_item.id,
                    via: 'frontend',
                    sort: 0,
                    key: 'content',
                    value: null,
                },
                {
                    vh_notification_id: this.active_item.id,
                    via: 'frontend',
                    sort: 1,
                    key: 'action',
                    value: null,
                    meta: {
                        action: null
                    }
                }
            ];

            this.$set(this.active_item.contents, 'frontend', lines);

            this.update('active_item', this.active_item);

        },
        //---------------------------------------------------------------------
        removeContent: function(item, via)
        {

            let lines = this.$vaah.removeInArrayByKey(this.active_item.contents[via], item, 'sort');

            this.active_item.contents[via] = lines;

            this.update('active_item', this.active_item);

        },
        //---------------------------------------------------------------------
        store: function () {
            this.$Progress.start();
            let params = this.active_item;
            let url = this.ajax_url+'/store';
            this.$vaah.ajax(url, params, this.storeAfter);
        },
        //---------------------------------------------------------------------
        storeAfter: function (data, res) {
            this.$Progress.finish();
            if(data){
                //this.update('list', data.list);
            }

        },
        //---------------------------------------------------------------------
        setSendTo: function(item)
        {
            this.send_to = item;
        },
        //---------------------------------------------------------------------
        sendNotification: function () {
            this.$Progress.start();
            this.is_sending = true;
            let params = {
                notification_id: this.active_item.id,
                user_id: this.send_to.id
            };

            console.log('--->', params);

            let url = this.ajax_url+'/send';
            this.$vaah.ajax(url, params, this.sendNotificationAfter);
        },
        //---------------------------------------------------------------------
        sendNotificationAfter: function (data, res) {
            this.$Progress.finish();
            this.is_sending = false;
            if(data){
                //this.update('list', data.list);
            }

        },
        //---------------------------------------------------------------------
        setMailButton: function () {

            let self =this;

            this.update('is_add_from_disabled', false);
            this.update('is_add_subject_disabled', false);

            if(self.active_item && self.active_item.contents
                && self.active_item.contents.mail){
                $.each( self.active_item.contents.mail, function( key, mail ) {
                    if(mail.key === 'from'){
                        self.update('is_add_from_disabled', true);
                    }

                    if(mail.key === 'subject'){
                        self.update('is_add_subject_disabled', true);
                    }
                });
            }
        },
        //---------------------------------------------------------------------
    }
}
