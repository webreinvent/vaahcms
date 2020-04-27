<template>

    <div v-if="assets.vue_notices" class="has-margin-bottom-20">

        <div v-for="notice in assets.vue_notices">



            <b-notification type="is-danger"
                            class="has-margin-bottom-5"
                            v-if="notice.meta.is_error"
                            @close="markAsRead(notice, true)"
                            aria-close-label="Close notification">

                <div class="level">
                    <div class="level-left">
                        {{notice.meta.message}}
                    </div>
                    <div class="level-right" v-if="notice.meta.action">
                        <b-button type="is-light"
                                  @close="click(notice)">
                            {{notice.meta.action.label}}
                        </b-button>
                    </div>
                </div>

            </b-notification>

            <b-notification type="is-info"
                            class="has-margin-bottom-5"
                            v-else
                            @close="markAsRead(notice, true)"
                            aria-close-label="Close notification">

                <div class="level">
                    <div class="level-left">
                        {{notice.meta.message}}
                    </div>
                    <div class="level-right" v-if="notice.meta.action">
                        <b-button type="is-light"
                                  @click="markAsRead(notice)">
                            {{notice.meta.action.label}}
                        </b-button>
                    </div>
                </div>

            </b-notification>

        </div>


    </div>


</template>
<script>

    export default {
        computed:{
            root() {return this.$store.getters['root/state']},
            assets() {return this.$store.getters['root/state'].assets},
            ajax_url() {return this.$store.getters['root/state'].ajax_url},
        },
        data()
        {
            let obj = {
                active_item: null,
            };

            return obj;
        },
        methods: {
            //---------------------------------------------------------------------
            update: function(name, value)
            {
                let update = {
                    state_name: name,
                    state_value: value,
                    namespace: 'root',
                };
                this.$vaah.updateState(update);
            },
            //---------------------------------------------------------------------
            markAsRead: function (item, dismiss = false) {
                this.active_item = item;
                this.active_item.dismiss = dismiss;

                console.log('--->', item);

                let params = item;
                let url = this.ajax_url+'/notices/mark-as-read';
                this.$vaah.ajax(url, params, this.markAsReadAfter);
            },
            //---------------------------------------------------------------------
            markAsReadAfter: function (data, res) {
                if(data){

                    let item  = this.active_item;

                    let list = this.$vaah.removeInArrayByKey(this.assets.vue_notices, this.active_item, 'id');
                    this.assets.vue_notices = list;
                    this.update('assets', this.assets);
                    this.active_item = null;

                    if(item.meta && item.meta.action
                        && item.meta.action.link && item.dismiss != true)
                    {
                        window.location.href = item.meta.action.link;
                    }

                }

            },
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
            //---------------------------------------------------------------------
        }
    }

</script>

