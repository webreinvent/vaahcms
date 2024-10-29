<template>
  <Message severity="info" :closable="true" class="is-small">This step will install dependencies.</Message>
  <div class="grid">
    <div class="col-12 md:col-6">
      <Card>
        <template #title>
          <div class="flex align-items-center justify-content-between">
            <h5 class="font-semibold">Cms</h5>
            <i class="pi pi-download bg-gray-200 p-2 border-round-3xl" style="font-size: 12px"></i>
          </div>
        </template>
        <template #content>
          <div class="mb-3">
            <Tag value="New" class="mr-2 bg-gray-200 text-black-alpha-80"></Tag>
            <Tag value="New" class="mr-2 bg-gray-200 text-black-alpha-80"></Tag>
            <Tag value="New" class="mr-2 bg-gray-200 text-black-alpha-80"></Tag>
          </div>
          <p class="text-xs">
            Cms module to manage your content
          </p>
          <p class="text-xs mb-3">
            Developed by: <a >Vaah</a>
          </p>
          <ProgressBar :value="value" class="mb-3" mode="indeterminate"/>
          <div class="field-checkbox">
            <Checkbox inputId="binary" v-model="checked" :binary="true" class="is-small" />
            <label for="binary" class="text-xs">Import Sample data</label>
          </div>
        </template>
        <template #footer>
          <Button icon="pi pi-check" label="Save" class="p-button-sm btn-primary-light is-small"/>
          <Button icon="pi pi-times" label="Cancel" class="p-button-sm btn-danger-light is-small" style="margin-left: .5em" />
        </template>
      </Card>
    </div>
    <div class="col-12 md:col-6">
      <Card>
        <template #title>
          <div class="flex align-items-center justify-content-between">
            <h5 class="font-semibold">Bulma Blog Theme</h5>
            <i class="pi pi-download bg-gray-200 p-2 border-round-3xl" style="font-size: 12px"></i>
          </div>
        </template>
        <template #content>
          <div class="mb-3">
            <Tag value="New" class="mr-2 bg-gray-200 text-black-alpha-80"></Tag>
            <Tag value="New" class="mr-2 bg-gray-200 text-black-alpha-80"></Tag>
            <Tag value="New" class="mr-2 bg-gray-200 text-black-alpha-80"></Tag>
          </div>
          <p class="text-xs">
            Bulma 0.9.2 Blog
          </p>
          <p class="text-xs mb-3">
            Developed by: <a >WebReinvent</a>
          </p>
          <ProgressBar :value="value" class="mb-3" mode="indeterminate"/>
          <div class="field-checkbox">
            <Checkbox inputId="binary" v-model="checked" :binary="true" class="is-small"/>
            <label for="binary" class="text-xs">Import Sample data</label>
          </div>
        </template>
        <template #footer>
          <Button icon="pi pi-check" label="Save" class="p-button-sm btn-primary-light is-small"/>
          <Button icon="pi pi-times" label="Cancel" class="p-button-sm btn-danger-light is-small" style="margin-left: .5em" />
        </template>
      </Card>
    </div>
    <div class="col-12">
      <ProgressBar :value="value" class="mt-4 mb-5" mode="indeterminate"/>
      <div class="my-3">
        <Button icon="pi pi-download" label="Download & install Dependencies" class="p-button-sm mr-2 is-small"/>
        <Button label="Skip" class="btn-dark p-button-sm is-small"/>
      </div>
    </div>
    <div class="col-12">
      <div class="flex justify-content-between">
        <Button label="Back" class="p-button-sm" @click="goBack"></Button>
        <Button label="Save & Next" class="p-button-sm" @click="goToNextStep"></Button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Dependencies",

  data() {
    return {
      value: 10,
      checked:false,
    }
  },
  methods:{
    goBack(){
      this.$router.push("/ui/public/install/migrate")
    },
    goToNextStep(){
      this.$router.push("/ui/public/install/account")
    },
  }

}
</script>

<style scoped lang="scss">
.p-progressbar{
  height: 8px;
}
</style>
