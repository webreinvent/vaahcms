<template>
  <Card>
    <template #header>
      <div class="pt-3 px-4 flex justify-content-between align-items-center">
        <div>
          <h5 class="font-semibold text-lg inline mr-2">Environment Variables</h5>
          <Tag class="mr-2">
            <p class="font-semibold">.env.rishu</p>
          </Tag>
        </div>
        <div>
          <Button icon="pi pi-download" class="mr-2"/>
          <Button icon="pi pi-refresh" class=""/>
        </div>
      </div>
    </template>
    <template #content>
      <div class="grid justify-content-start">
        <div class="col-12 md:col-6" v-for="(item,index) in envVariables">
          <h5 class="text-left p-1">{{item.name}}</h5>
          <div class="p-inputgroup">
            <Textarea :model-value="item.value" :autoResize="true"/>
            <Button icon="pi pi-copy" class=""/>
            <Button icon="pi pi-trash" class="p-button-danger"/>
          </div>
        </div>
      </div>
      <div class="grid justify-content-start mt-5">
        <div class="col-12 md:col-6">
          <div class="p-inputgroup">
            <InputText v-model="addEnvVariable" v-if="showEnvInput"></InputText>
            <Button label="Add Env Variable" icon="pi pi-plus" @click="addLinkHandler"></Button>
          </div>
        </div>
        <div class="col-12 md:col-6">
          <div class="p-inputgroup justify-content-end">
            <Button label="Save" icon="pi pi-save"></Button>
          </div>
        </div>
      </div>
    </template>
  </Card>

</template>

<script>
export default {
  name: "EnvVariableSettings",
  data(){
    return{
      envVariables: [
        {
          name:'APP_NAME',
          value:'test-project',
        },
        {
          name:'APP_ENV',
          value:null,
        },
        {
          name:'APP_KEY',
          value:null,
        },
        {
          name:'APP_DEBUG',
          value:null,
        },
        {
          name:'APP_URL',
          value:null,
        },
        {
          name:'APP_TIMEZONE',
          value:null,
        },
        {
          name:'VAAHCMS_VERSION',
          value:null,
        },
        {
          name:'CENTRAL_DOMAIN',
          value:null,
        },
        {
          name:'APP_VAAHCMS_ENV',
          value:null,
        },
        {
          name:'APP_KEY',
          value:null,
        }
      ],
      addEnvVariable:null,
      showEnvInput:true
    }
  },
  methods:{
    addLinkHandler(){
      if(!this.showEnvInput){
        return this.showEnvInput = true;
      }else if(this.showEnvInput && this.addEnvVariable !== "" && this.addEnvVariable !== null){
        this.envVariables.push(
            {
              name:this.addEnvVariable,
              value: null
            }
        );
        this.addEnvVariable = null;
        return this.showEnvInput = true;
      }
    }
  }
}
</script>

<style scoped>

</style>
