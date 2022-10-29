<template>
<Card>
  <template #header>
    <div class="flex justify-content-between align-items-center">
      <h5 class="font-semibold text-lg white-space-nowrap">Update VaahCMS</h5>
      <div class="p-inputgroup justify-content-end">
        <Button icon="pi pi-refresh" label="Check for Update" @click="update = !update"></Button>
      </div>
    </div>
  </template>
  <template #content>
    <div class="text-center" v-if="!update">
        <h4>Current Version of</h4>
        <p><Tag>VaahCMS</Tag> is <Tag>v1.6.10</Tag></p>
    </div>
      <div v-else class="text-sm">
          <p class="mb-3">A newer version <b>1.7.18</b> of VaahCMS is available.</p>

          <h5 class="font-semibold">NEW Updates:</h5>
          <ul class="mb-3">
              <li>
                  -['f1su214'](https:/github.com/vaahcms/commit/skdjlfkj35ldj83ndkjng) Added: auth-api - ['nbh53']
              </li>
          </ul>
          <div class="field-checkbox">
              <Checkbox inputId="binary" v-model="checked" :binary="true" />
              <label for="binary">Have you taken the backup of your files & database?</label>
          </div>
          <Button label="Update Now" class="p-button-sm mt-2 mb-3"></Button>
          <div class="grid m-0">
              <div class="col-3">
                  <ol>
                      <li>
                          Download latest version (it can take upto 3 to 5 minutes) <i class="pi pi-refresh"></i>
                      </li>
                      <li>
                          Publish assets
                      </li>
                      <li>
                          Run migrations and seeds
                      </li>
                      <li>
                          Clear cache
                      </li>
                  </ol>
                  <Button label="Reload" class="p-button-sm p-button-success mt-3"></Button>
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
::v-deep(.dark-demo-terminal) {
    background-color: #212121;
    color: #ffffff;

    .p-terminal-command {
        color: #80CBC4;
    }

    .p-terminal-prompt {
        color: #FFD54F;
    }

    .p-terminal-response {
        color: #9FA8DA;
    }
}
</style>
