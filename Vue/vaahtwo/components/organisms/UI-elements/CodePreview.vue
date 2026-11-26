<template>
  <div>
    <h5>{{ name }}</h5>

        <Tabs value="0" ref="tabview1">
        <TabList>
            <Tab value="0">Preview</Tab>
            <Tab value="1">Code</Tab>
        </TabList>
        <TabPanels>
            <TabPanel value="0">

        <slot/>
                  </TabPanel>
            <TabPanel value="1">

              <pre v-if="props && props.code" v-highlightjs="props.code">
                <code class="javascript">
              </code>
              </pre>
                  </TabPanel>
        </TabPanels>
    </Tabs>

  </div>

</template>
<script setup>
const props = defineProps(['name', 'code']);

</script>
