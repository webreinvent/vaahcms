<template>
    <Card>
        <template #header>
            <div class="flex justify-content-between align-items-center">
                <h5 class="font-semibold vc-text-16 white-space-nowrap">Update VaahCMS</h5>
                <InputGroup class="justify-content-end">
                    <Button size="small" icon="pi pi-refresh" label="Check for Update" @click="update = !update" class=""></Button>
                </InputGroup>
            </div>
        </template>
        <template #content>
            <div class="text-center" v-if="!update">
                <h4 class="mb-3">Current Version of</h4>
                <p><Tag>VaahCMS</Tag> is <Tag>v1.6.10</Tag></p>
            </div>
            <div v-else class="vc-text-14">
                <p class="mb-3">A newer version <b>1.7.18</b> of VaahCMS is available.</p>

                <h5 class="font-semibold vc-text-14">NEW Updates:</h5>
                <ol class="mb-3 pl-3">
                    <li class="mb-2">
                        ['f1su214'](https:/github.com/vaahcms/commit/skdjlfkj35ldj83ndkjng) Added: auth-api - ['nbh53']
                    </li>
                    <li>
                        Test feature
                    </li>
                </ol>
                <div class="field-checkbox mt-5">
                    <Checkbox inputId="binary" v-model="checked" :binary="true" class="vc-dense"/>
                    <label for="binary">Have you taken the backup of your files & database?</label>
                </div>
                <Button size="small" label="Update Now" class=" mt-2 mb-3"></Button>
                <div class="grid m-0">
                    <div class="col-3">
                        <ol class="pl-3">
                            <li class="mb-2">
                                Downloading latest version (it can take upto 3 to 5 minutes) <i class="pi pi-spin pi-spinner"></i>
                            </li>
                            <li class="mb-2">
                                Publish assets <i class="pi pi-check"></i>
                            </li>
                            <li class="mb-2">
                                Run migrations and seeds
                            </li>
                            <li>
                                Clear cache
                            </li>
                        </ol>
                        <Button size="small" label="Reload" icon="pi pi-refresh" class=" p-button-success mt-3"></Button>
                    </div>
                    <div class="col-9">
                        <Terminal welcomeMessage="Step 1/4 : Updating dependencies" prompt="primevue $" class="dark-demo-terminal" />
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>

<script>
export default {
  name: "UpdateSettings",
    data(){
      return{
          update:false,
          backup_options:[
              {
                  label:'Yes',
                  value: true
              },
              {
                  label:'No',
                  value:false
              }
          ]
      }
    }
}
</script>

<style scoped lang="scss">
/* The terminal is a fixed-dark demo widget: the Nide surface scale is a
   neutral ramp in both colour schemes, so these neutral primitives stay
   dark/white in light AND dark mode — exactly the widget's intent (a mock
   terminal never flips with the app scheme). The coloured lines bind the
   hue-correct primitive palette tokens (teal / yellow / indigo, 300–400
   shades) instead of literal hex. */
::v-deep(.dark-demo-terminal) {
    background-color: var(--p-surface-900);
    color: var(--p-surface-0);

    .p-terminal-command {
        color: var(--p-teal-300);
    }

    .p-terminal-prompt {
        color: var(--p-yellow-400);
    }

    .p-terminal-response {
        color: var(--p-indigo-300);
    }
}
</style>
