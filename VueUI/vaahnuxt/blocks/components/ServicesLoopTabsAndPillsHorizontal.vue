<template>
  <section class="ServicesLoopTabsAndPillsHorizontal has-background-light">
    <div class="spacer horizontal-tabs">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-10">
            <b-tabs type="is-boxed">
              <b-tab-item v-if="content.tabs" v-for="(tab, index) in content.tabs" v-bind:key="index" :label="tab.heading">
                <p class="content has-text-justify">{{tab.details}}</p>
                <div class="columns">
                  <div v-if="tab.list" v-for="item in tab.list" class="column is-3">
                    <ul style="list-style: none" class="pl-0">
                      <li><img :src="item.src" class="img-fluid is-centered d-block" alt=""></li>
                      <li class="has-text-centered content">{{item.items}}</li>
                    </ul>
                  </div>
                </div>
              </b-tab-item>
            </b-tabs>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>


  export default {
    props: ['content']
  }
</script>
<style scoped>

</style>

