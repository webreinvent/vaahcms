<template>
  <div>
    <h5>{{ name }}</h5>

    <TabView ref="tabview1">
      <TabPanel header="Preview">
        <slot/>
      </TabPanel>
      <TabPanel header="Code">
              <pre v-if="props && props.code" v-highlightjs="props.code">
                <code class="javascript">
              </code>
              </pre>
      </TabPanel>

    </TabView>

  </div>

</template>
<script setup>
const props = defineProps(['name', 'code']);

</script>
