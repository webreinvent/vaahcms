<template>

    <div class="modal" v-if="page.assets && page.assets.types"
         :class="page.is_type_modal_active?'is-active':''">
        <div class="modal-background"></div>
        <div class="modal-content" style="width: 640px !important;">

            <div class="card">
                <div class="card-header">
                    <div class="card-header-title">
                        Taxonomy Types
                    </div>
                    <div class="card-header-icon">
                        <b-field>

                            <tree-select style="width: 52%" v-model="taxo_type.parent_id"
                                         placeholder="Select a Parent"
                                         :clearable="false"
                                         :normalizer="normalizer"
                                         :multiple="false" :options="page.assets.types" >

                            </tree-select>

                            <b-input name="taxonomies-type-name" dusk="taxonomies-type-name"
                                     v-model="taxo_type.name"></b-input>

                            <p class="control">
                                <b-button @click="addType" class="button is-primary">Add</b-button>
                            </p>
                        </b-field>
                    </div>

                </div>
                <div class="card-content">
                    <div v-if="data">
                        <vue-tree-list
                                @change-name="onChangeName"
                                @delete-node="onDel"
                                @drop="onDrop"
                                @drop-before="onDrop"
                                :model="data"
                                v-bind:default-expanded="false"
                        >
                            <template v-slot:leafNameDisplay="slotProps">
        <span>
          <span class="muted">
              <b-tooltip label="Copy Id" type="is-dark">
                <vh-copy class="text-copyable"
                         :data="slotProps.model.id"
                         :label="'#'+slotProps.model.id"
                         @copied="copiedData">
                </vh-copy>
              </b-tooltip>
          </span>
            <b-tooltip label="Copy Slug" type="is-dark">
                <vh-copy class="text-copyable"
                         :data="slotProps.model.slug"
                         :label="slotProps.model.name"
                         @copied="copiedData">
                </vh-copy>
            </b-tooltip>
            <strong v-if="slotProps.model.children" class="muted">
                ({{ slotProps.model.children.length }})
            </strong>
        </span>
                            </template>
                            <span class="icon" slot="editNodeIcon">
                <b-icon icon="edit"
                        size="is-small">
                </b-icon>
            </span>
                            <span class="icon" slot="delNodeIcon">
                <b-icon icon="trash"
                        size="is-small">
                </b-icon>
            </span>
                        </vue-tree-list>
                    </div>
                </div>

            </div>

        </div>
        <button class="modal-close is-large"
                @click="page.is_type_modal_active = false"
                aria-label="close"></button>
    </div>


</template>

<script>
    import { VueTreeList, Tree, TreeNode } from 'vue-tree-list'

    import TreeSelect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'

    let namespace = 'taxonomies';

    export default {
        computed:{
            root() {return this.$store.getters['root/state']},
            page() {return this.$store.getters[namespace+'/state']},
            ajax_url() {return this.$store.getters[namespace+'/state'].ajax_url},
            item() {return this.$store.getters[namespace+'/state'].active_item},
        },
        components: {
            TreeSelect,
            VueTreeList
        },
        watch: {
            'page.assets.types': {
                deep: true,
                handler(new_val, old_val) {

                    if(new_val){
                        this.data = new Tree(
                            new_val
                        );
                    }

                }
            }
        },
        data() {
            return {
                namespace: namespace,
                newTree: {},
                taxo_type: {
                    parent_id:null,
                    name:null
                },
                data: null
            }
        },
        mounted() {

            if(this.page && this.page.assets && this.page.assets.types) {
                this.data = new Tree(
                    this.page.assets.types
                );
            }



            // $("span[title]").css("display", "none");
        },
        methods: {
            onDel(node) {
                this.$Progress.start();

                this.params = {
                    id : node.id
                };

                let url = this.ajax_url+'/deleteTaxonomyType';
                this.$vaah.ajax(url, this.params, this.onDelAfter);
            },
            //---------------------------------------------------------------------
            onDelAfter: function(data, res)
            {
                this.$Progress.finish();

                if(res.data.status === 'success'){

                    this.$store.dispatch(namespace+'/reloadAssets');

                }
            },
            copiedData: function (data) {

                this.$vaah.toastSuccess(['copied']);

                this.$vaah.console(data, 'copied data');

            },

            onChangeName: function (params) {

                if(params && params.eventType &&
                    params.eventType === 'blur'){

                    this.$Progress.start();

                    this.params = params;

                    let url = this.ajax_url+'/updateTaxonomyType';
                    this.$vaah.ajax(url, this.params, this.onChangeNameAfter);

                }
            },

            onChangeNameAfter: function (data, res) {

                this.$Progress.finish();

                if(res.data.status === 'success'){

                    this.$store.dispatch(namespace+'/reloadAssets');

                    this.$emit('eReloadList');

                }else{
                    this.data = new Tree(
                        this.page.assets.types
                    );
                }

            },

            onDrop: function (params) {

                this.$Progress.start();

                this.params = {
                    id:params.node.id,
                    parent_id:params.node.parent.id
                };

                let url = this.ajax_url+'/updateTaxonomyTypePosition';
                this.$vaah.ajax(url, this.params, this.onDropAfter);

            },

            onDropAfter: function (data,res) {

                this.$Progress.finish();

                if(res.data.status === 'success'){

                    this.$store.dispatch(namespace+'/reloadAssets');

                }

            },

            //---------------------------------------------------------------------
            addType: function()
            {
                this.$Progress.start();

                this.params = this.taxo_type;

                let url = this.ajax_url+'/createTaxonomyType';
                this.$vaah.ajax(url, this.params, this.addTypeAfter);
            },
            //---------------------------------------------------------------------
            addTypeAfter: function(data, res)
            {
                this.$Progress.finish();

                if(res.data.status === 'success'){

                    this.taxo_type= {
                        parent_id:null,
                        name:null
                    };

                    this.$store.dispatch(namespace+'/reloadAssets');

                }
            },
            //---------------------------------------------------------------------


            //---------------------------------------------------------------------
            normalizer: function (node) {

                let data = {
                    label: node.name,
                };

                if(node.children && node.children.length === 0){
                    delete node.children;
                }

                return data;
            },
        }
    }
</script>

<style>
    span[title="Add Tree Node"]{
        display: none;
    }
    span[title="Add Leaf Node"]{
        display: none;
    }
    span[title="edit"]{
        cursor: pointer;
    }
    span[title="delete"]{
        cursor: pointer;
    }
</style>

