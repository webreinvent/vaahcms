<template>
    <div class="grid">
        <div class="col-6 col-offset-3 mt-6">
            <DataTable :value="pages" stripedRows responsiveLayout="scroll" class="p-datatable-sm" showGridlines>
                <Column header="Pages">
                    <template #body="slotProps">
                        <p>{{slotProps.data.label}}</p>
                    </template>
                </Column>
                <Column header="Link">
                    <template #body="slotProps">
                        <router-link :to="slotProps.data.to" class="mr-2" target="_blank">
                            <Button icon="pi pi-link" class="p-button-rounded p-button-sm"></Button>
                        </router-link>
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>

<script>
export default {
    name: "Pages",
    data(){
        return{
            pages :[
                {
                    label:'Signin',
                    to:'/ui/public/signin'
                },
                {
                    label:'Signup',
                    to:'/ui/public/signup'
                },
                {
                    label:'Multi factor authentication',
                    to:'/ui/public/multi-factor-auth'
                },
                {
                    label:'Forgot Password',
                    to:'/ui/public/forgot-password'
                },
                {
                    label:'Dashboard',
                    to:'/ui/private/dashboard'
                },
                {
                    label:'Install VaahCMS',
                    to:'/ui/public/install/configuration'
                },
                {
                    label:'Setup',
                    to:'/ui/public/setup'
                },
                {
                    label:'Settings',
                    to:'/ui/private/settings/general-settings'
                },
                {
                    label:'Users',
                    to:'/ui/private/users'
                },
                {
                    label:'Extend',
                    to:'/ui/private/extend'
                },
                {
                    label:'Taxonomies',
                    to:'/ui/private/taxonomies'
                },
                {
                    label: 'Media',
                    to: '/ui/private/media'
                }
            ],
            dataModel: [
                {
                    id: "numberOrString",
                    label: "Root Node",
                    children: [
                        {id: 1, label: "Child Node"},
                        {id: "node2", label: "Second Child"}
                    ]
                }
            ],
            tree2Data: [
                {
                    id: 'dragdrop2-node1',
                    label: 'Node One',
                    children: [],
                    treeNodeSpec: {
                        addChildCallback: function () { return Promise.resolve({ id: '' + Math.random(), label: 'Added' }); }
                    }
                },
                {
                    id: 'dragdrop2-node2',
                    label: 'Node Two',
                    children: [
                        {
                            id: 'dragdrop2-subnode1',
                            label: 'Subnode One',
                            children: []
                        },
                        {
                            id: 'dragdrop2-subnode2',
                            label: 'Subnode Two',
                            children: [
                                {
                                    id: 'dragdrop2-subsubnode1',
                                    label: 'Sub-Subnode 1',
                                    children: []
                                },
                                {
                                    id: 'dragdrop2-subsubnode2',
                                    label: 'Sub-Subnode 2',
                                    children: []
                                }
                            ]
                        }
                    ]
                }
            ],
            modelDefaults:{expanderTitle: 'Expand this node',
                draggable: true,
                allowDrop: true,
                state: {
                    expanded: true
                }}
        }
    },
}
</script>

<style lang="scss">

</style>
