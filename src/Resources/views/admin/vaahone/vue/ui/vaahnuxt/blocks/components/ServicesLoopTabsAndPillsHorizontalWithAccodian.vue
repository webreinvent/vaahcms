<template>
  <section class="has-background-light ServicesLoopTabsAndPillsHorizontalWithAccodian">
    <div class="spacer horizontal-tabs">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-10">
            <b-tabs type="is-boxed">
              <b-tab-item v-if="content.tabs" v-for="(tab, index) in content.tabs" v-bind:key="index" :label="tab.heading">
                <p class="content">{{tab.details}}</p>
                <div class="columns">
                  <div class="column is-12">
                    <b-collapse
                      class="card"
                      v-for="(faq, index) of tab.freq"
                      :key="index"
                      @open="isOpen = index">
                      <div
                        slot="trigger"
                        slot-scope="props"
                        class="card-header"
                        role="button">
                        <p class="card-header-title">
                          {{ faq.heading }}
                        </p>
                        <a class="card-header-icon">
                          <b-icon
                            :icon="props.open ? 'menu-down' : 'menu-up'">
                          </b-icon>
                        </a>
                      </div>
                      <div class="card-content">
                        <div class="content">
                          {{ faq.body }}
                        </div>
                      </div>
                    </b-collapse>
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

