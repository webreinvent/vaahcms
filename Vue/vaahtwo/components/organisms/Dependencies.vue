<template>
  <Message severity="info" :closable="true" class="vc-dense">This step will install dependencies.</Message>
  <div class="grid">
    <div class="col-12 md:col-6">
      <Card>
        <template #title>
          <div class="flex align-items-center justify-content-between">
            <h5 class="font-semibold">Cms</h5>
            <i class="pi pi-download vc-icon-neutral p-2 border-round-3xl" style="font-size: 12px"></i>
          </div>
        </template>
        <template #content>
          <div class="mb-3">
            <Tag value="New" severity="secondary" class="mr-2"></Tag>
            <Tag value="New" severity="secondary" class="mr-2"></Tag>
            <Tag value="New" severity="secondary" class="mr-2"></Tag>
          </div>
          <p class="vc-text-12">
            Cms module to manage your content
          </p>
          <p class="vc-text-12 mb-3">
            Developed by: <a >Vaah</a>
          </p>
          <ProgressBar :value="value" class="mb-3" mode="indeterminate"/>
          <div class="field-checkbox">
            <Checkbox inputId="binary" v-model="checked" :binary="true" class="vc-dense" />
            <label for="binary" class="vc-text-12">Import Sample data</label>
          </div>
        </template>
        <template #footer>
          <!-- M7-T4 — the v3 `btn-primary-light` / `btn-danger-light` soft
             footers are the v4 outlined row (the `btn-*-light` classes never
             survived into the v4 CSS). -->
          <Button size="small" icon="pi pi-check" label="Save" variant="outlined" class=" vc-dense"/>
          <Button size="small" icon="pi pi-times" label="Cancel" severity="danger" variant="outlined" class=" vc-dense" style="margin-left: .5em" />
        </template>
      </Card>
    </div>
    <div class="col-12 md:col-6">
      <Card>
        <template #title>
          <div class="flex align-items-center justify-content-between">
            <h5 class="font-semibold">Bulma Blog Theme</h5>
            <i class="pi pi-download vc-icon-neutral p-2 border-round-3xl" style="font-size: 12px"></i>
          </div>
        </template>
        <template #content>
          <div class="mb-3">
            <Tag value="New" severity="secondary" class="mr-2"></Tag>
            <Tag value="New" severity="secondary" class="mr-2"></Tag>
            <Tag value="New" severity="secondary" class="mr-2"></Tag>
          </div>
          <p class="vc-text-12">
            Bulma 0.9.2 Blog
          </p>
          <p class="vc-text-12 mb-3">
            Developed by: <a >WebReinvent</a>
          </p>
          <ProgressBar :value="value" class="mb-3" mode="indeterminate"/>
          <div class="field-checkbox">
            <Checkbox inputId="binary" v-model="checked" :binary="true" class="vc-dense"/>
            <label for="binary" class="vc-text-12">Import Sample data</label>
          </div>
        </template>
        <template #footer>
          <!-- M7-T4 — the v3 `btn-primary-light` / `btn-danger-light` soft
             footers are the v4 outlined row (the `btn-*-light` classes never
             survived into the v4 CSS). -->
          <Button size="small" icon="pi pi-check" label="Save" variant="outlined" class=" vc-dense"/>
          <Button size="small" icon="pi pi-times" label="Cancel" severity="danger" variant="outlined" class=" vc-dense" style="margin-left: .5em" />
        </template>
      </Card>
    </div>
    <div class="col-12">
      <ProgressBar :value="value" class="mt-4 mb-5" mode="indeterminate"/>
      <div class="my-3">
        <Button size="small" icon="pi pi-download" label="Download & install Dependencies" class=" mr-2 vc-dense"/>
        <Button size="small" label="Skip" severity="contrast" class="vc-dense"/>
      </div>
    </div>
    <div class="col-12">
      <div class="flex justify-content-between">
        <Button size="small" label="Back" class="" @click="goBack"></Button>
        <Button size="small" label="Save & Next" class="" @click="goToNextStep"></Button>
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
