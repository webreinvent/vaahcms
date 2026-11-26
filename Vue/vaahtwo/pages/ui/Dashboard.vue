<template>
    <div class="grid dashboard">
        <div class="col-12 md:col-8 pr-3">
            <Card>
                <template #content>
                    <h5 class="vc-text-20 font-semibold mb-1">Welcome to Vaah<b>cms</b></h5>
                    <p class="vc-text-14">We've assembled some links to get you started:</p>
                    <div class="grid mt-4">
                        <div class="col-12 md:col-4">
                            <h6 class="font-semibold mb-2 vc-text-14">Get Started</h6>
                            <Button size="small" label="Go to Theme" variant="outlined"></Button>
                            <p class="vc-text-12 mt-2">or,<a class="cursor-pointer vc-link"> create your own theme</a></p>
                        </div>
                        <div class="col-12 md:col-4">
                            <h6 class="font-semibold mb-2 vc-text-14">Next Steps</h6>
                            <ul class="links-list">
                                <li>
                                    <a><i class="pi pi-desktop"></i>View your site</a>
                                </li>
                                <li>
                                    <a><i class="pi pi-eye"></i>View Pages</a>
                                </li>
                                <li>
                                    <a><i class="pi pi-plus"></i>Add Pages</a>
                                </li>
                                <li>
                                    <a><i class="pi pi-pencil"></i>Add a Content Type</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 md:col-4">
                            <h6 class="font-semibold mb-2 vc-text-14">More Actions</h6>
                            <ul class="links-list">
                                <li>
                                    <a><i class="pi pi-box"></i>Manage your modules</a>
                                </li>
                                <li>
                                    <a><i class="pi pi-bars"></i>Manage Menus</a>
                                </li>
                                <li>
                                    <a><i class="pi pi-microsoft"></i>Manage Blocks</a>
                                </li>
                                <li>
                                    <a><i class="pi pi-file"></i>Learn more about CMS</a>
                                </li>
                            </ul>
                        </div>
                        <Divider  class="dashboard-divider"></Divider>
                        <div class="col-12">
                            <h5 class="vc-text-16 font-semibold mb-4">Users and roles</h5>
                            <div class="grid m-0">
                                <div class="col">
                                <span class="p-3 vc-chip">
                                    <i class="pi pi-user"></i>
                                </span>
                                    <p class="vc-text-14 font-semibold mt-3">Total Users</p>
                                    <h6 class="vc-text-20 font-semibold my-2">1683</h6>
                                    <a href="" class="vc-text-13 vc-link">View Details</a>
                                </div>
                                <Divider layout="vertical" class="hidden md:block"></Divider>
                                <Divider class="md:hidden"></Divider>
                                <div class="col">
                                <span class="p-3 vc-chip">
                                    <i class="pi pi-user"></i>
                                </span>
                                    <p class="vc-text-14 font-semibold mt-3">Total Roles</p>
                                    <h6 class="vc-text-20 font-semibold my-2">7</h6>
                                    <a href="" class="vc-text-13 vc-link">View Details</a>
                                </div>
                                <Divider layout="vertical" class="hidden md:block"></Divider>
                                <Divider class="md:hidden"></Divider>
                                <div class="col">
                                <span class="p-3 vc-chip">
                                    <i class="pi pi-user"></i>
                                </span>
                                    <p class="vc-text-14 font-semibold mt-3">Total Permissions</p>
                                    <h6 class="vc-text-20 font-semibold my-2">62</h6>
                                    <a href="" class="vc-text-13 vc-link">View Details</a>
                                </div>
                                <Divider layout="vertical" class="hidden md:block"></Divider>
                                <Divider class="md:hidden"></Divider>
                                <div class="col">
                                <span class="p-3 vc-icon-success">
                                    <i class="pi pi-user"></i>
                                </span>
                                    <p class="vc-text-14 font-semibold mt-3">Active Users</p>
                                    <h6 class="vc-text-20 font-semibold my-2">1683</h6>
                                    <a href="" class="vc-text-13 vc-link">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </Card>
        </div>
        <div class="col-12 md:col-4 pl-1">
            <Button size="small" label="Check Updates" icon="pi pi-refresh" variant="outlined" class="mr-2 mb-3"></Button>
            <Button size="small" label="Getting Started" icon="pi pi-play" variant="outlined" class="mb-3"></Button>
            <Accordion :multiple="true" :value="active_index">
                <AccordionPanel :value="0">
                    <AccordionHeader>Jobs
                    </AccordionHeader>
                    <AccordionContent>

                    <Message severity="warn" :closable="false" class="mt-0">Enable <span class="font-bold">Laravel Queues</span> to run your jobs. <a class="cursor-pointer">View Settings</a> </Message>
                    <p class="vc-text-13">
                        Tasks that is kept in the queue to be performed one after another. Queues allow you to defer the processing of a time consuming task, such as sending an e-mail, until a later time which drastically speeds up web requests to your application.
                    </p>
                    <Divider class="dashboard-divider"></Divider>
                    <div class="flex justify-content-evenly align-items-center align-items-center -my-2">
                        <a href="" class="text-center"><i class="pi pi-envelope mr-2"></i>4 Pending</a>
                        <Divider layout="vertical"></Divider>
                        <a href="" class="text-center"><i class="pi pi-ban mr-2"></i>0 Failed</a>
                    </div>
                
                    </AccordionContent>
                </AccordionPanel>
                <AccordionPanel :value="1">
                    <AccordionHeader>Laravel logs (1)
                    </AccordionHeader>
                    <AccordionContent>

                    <div class="flex justify-content-between">
                        <p class="vc-text-14">
                            laravel-2022-10-12.log
                        </p>
                        <a href="" class="vc-text-13 vc-link">View</a>
                    </div>
                
                    </AccordionContent>
                </AccordionPanel>
            </Accordion>
        </div>
        <div class="col-12">
            <div class="vc-text-12 text-center footer-text"><p>
                © 2022.
                <a class="" href="https://vaah.dev/cms" target="_blank">VaahCMS</a>
                v1.6.10
                | <a class="" href="https://docs.vaah.dev/vaahcms" target="_blank">Documentation</a></p> <p class="text-center">
                Laravel v8.41.0
                | PHP v8.0.18
            </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    data(){
        return{
            active_index:[0,1]
        }
    }
}
</script>

<style scoped lang="scss">
.dashboard{
    .dashboard-divider{
        &:before{
            width:calc(100% + 2rem);
            margin-left: -1rem;
        }
    }
    ul{
        padding-left: 0;
        &.links-list{
            list-style-type: none;
            li{
                &:not(:last-child){
                    margin-bottom:12px
                }
                a{
                    cursor: pointer;
                    i{
                        margin-right: 5px;
                    }
                }
            }
        }
    }
    .footer-text{
        margin-top: 75px;
    }
}
</style>
