<template>
  <section class="ServicesLoopTabsAndPills has-background-light">
    <div class="spacer">
      <div class="container">
        <div class="columns">
          <div class="column is-12">
            <b-tabs :position="atRight ? 'is-right' : ''"
                    :size="size"
                    :type="type"
                    vertical
                    :expanded="expanded">
              <b-tab-item v-if="content.tabs" v-for="(tab, index) in content.tabs" v-bind:key="index" :label="tab.heading">
                <img :src="tab.src" alt="EmphoSys" class="rounded img-fluid">
                <p class="content has-text-justify">{{tab.details}}</p>
                <div class="columns">
                  <div v-if="tab.list" v-for="item in tab.list" class="column is-3">
                    <ul style="list-style: none" class="pl-0">
                      <li><img :src="item.src" class="img-fluid is-centered d-block" alt=""></li>
                      <li class="has-text-centered content mt-2">{{item.items}}</li>
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
    props: ['content'],
    data() {
      return {
        expanded: false,
        atRight: false,
        size: null,
        type: null
      }
    }
  }
</script>

