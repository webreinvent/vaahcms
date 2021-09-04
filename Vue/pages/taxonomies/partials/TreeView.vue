<template>
    <div>
<!--        <button @click="addNode">Add Type</button>-->
        <vue-tree-list
                @delete-node="onDel"
                :model="data"
                v-bind:default-expanded="false"
        >
            <template v-slot:leafNameDisplay="slotProps">
        <span>
          <span class="muted">#{{ slotProps.model.id }}</span> {{ slotProps.model.name }}
            <strong v-if="slotProps.model.children" class="muted">
                ({{ slotProps.model.children.length }})
            </strong>
        </span>
            </template>
            <span class="icon" slot="addTreeNodeIcon">📂</span>
            <span class="icon" slot="editNodeIcon">📃</span>
            <span class="icon" slot="delNodeIcon">✂️</span>
        </vue-tree-list>
    </div>
</template>

<script>
    import { VueTreeList, Tree, TreeNode } from 'vue-tree-list'
    export default {
        props:{
            value: {
                type: String|Number|Array|Object,
                default: null
            },
            ajax_url: {
                type: String,
                default: null
            }
        },
        components: {
            VueTreeList
        },
        watch: {
            value(mew, old) {
                this.data= new Tree(
                    mew
                )
            }
        },
        data() {
            return {
                newTree: {},
                data: new Tree(
                    this.value
                )
            }
        },
        mounted() {
            console.log('123',this.value);
        },
        methods: {
            onDel(node) {
                console.log(node,this.ajax_url);
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

                console.log(res);

                if(res.data.status === 'success'){

                    let update = {
                        state_name: 'assets_is_fetching',
                        state_value: false,
                        namespace: 'taxonomies',
                    };
                    this.$vaah.updateState(update);

                    this.$store.dispatch('taxonomies/getAssets');

                }
            }
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
        display: none;
    }
</style>

