<script  setup>
    import {onMounted, reactive} from "vue";

    import { useSetupStore } from '../../stores/setup'
    const store = useSetupStore();
    import { useRootStore } from '../../stores/root'
    const root = useRootStore();

    onMounted(async () => {
        root.verifyInstallStatus();
        await root.getAssets();

    });
</script>
<template  >

    <div v-if="root.assets && is_installation_verified">
        <div class="grid flex justify-content-center flex-wrap ">
            <div class="col-5 flex align-items-center justify-content-center ">

                <div class="flex justify-content-center">
                    <div class="card">
                        <h5 class="text-center text-4xl">Sign In</h5>
                        <form  class="p-fluid">
                            <div class="field">
                                <div class="p-float-label p-input-icon-right">
                                    <i class="pi pi-envelope" />
                                    <InputText id="email"  />
                                </div>
                            </div>
                            <div class="field">
                                <div class="p-float-label p-input-icon-right">
                                    <i class="pi pi-envelope" />
                                    <InputText id="email"  />
                                </div>
                            </div>

                            <Button type="submit" label="Submit" class="mt-2" />
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</template>


