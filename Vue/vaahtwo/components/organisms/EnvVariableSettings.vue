<template>
    <Card>
        <template #header>
            <div class="flex justify-content-between align-items-center">
                <div>
                    <h5 class="font-semibold vc-text-16 inline mr-2">Environment Variables</h5>
                    <Tag class="mr-2">
                        <p class="font-semibold">.env.rishu</p>
                    </Tag>
                </div>
                <div>
                    <Button size="small" icon="pi pi-download" class="mr-2"/>
                    <Button size="small" icon="pi pi-refresh" class=""/>
                </div>
            </div>
        </template>
        <template #content>
            <div class="grid justify-content-start">
                <div class="col-12 md:col-6" v-for="(item,index) in envVariables">
                    <h5 class="p-1 vc-text-12 mb-1">{{item.name}}</h5>
                    <InputGroup>
                        <Textarea :model-value="item.value" :autoResize="true" class="has-min-height"/>
                        <Button icon="pi pi-copy" class=" has-max-height"/>
                        <Button icon="pi pi-trash" class="p-button-danger has-max-height"/>
                    </InputGroup>
                </div>
            </div>
            <div class="grid justify-content-start mt-5">
                <div class="col-12 md:col-6">
                    <InputGroup>
                        <InputText v-model="addEnvVariable" v-if="showEnvInput"></InputText>
                        <Button label="Add Env Variable" icon="pi pi-plus" @click="addLinkHandler"></Button>
                    </InputGroup>
                </div>
                <div class="col-12 md:col-6">
                    <InputGroup class="justify-content-end">
                        <Button label="Save" icon="pi pi-save"></Button>
                    </InputGroup>
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
