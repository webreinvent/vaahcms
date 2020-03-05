<template>
  <div class="spacer ServiceFeaturesFourColouredBoxes">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title">{{content.heading}}</h2>
          <h6 class="subtitle">{{content.details}}</h6>
        </div>
      </div>
      <div class="columns">
        <div v-if="content.features" v-for="(feature, index) in content.features" class="column is-6">
          <div v-if="index%4==0" class="box p-4 bg-blue mt-4">
            <h4 class="has-text-centered mb-0">{{feature.heading}}</h4>
            <p class="mb-0">{{feature.details}}</p>
          </div>
          <div v-else-if="index%4==1" class="box p-4 bg-green mt-4">
            <h4 class="has-text-centered mb-0">{{feature.heading}}</h4>
            <p class="mb-0">{{feature.details}}</p>
          </div>
          <div v-else-if="index%4==2" class="box p-4 bg-yellow mt-4">
            <h4 class="has-text-centered mb-0">{{feature.heading}}</h4>
            <p class="mb-0">{{feature.details}}</p>
          </div>
          <div v-else-if="index%4==3" class="box p-4 bg-red mt-4">
            <h4 class="has-text-centered mb-0">{{feature.heading}}</h4>
            <p class="mb-0">{{feature.details}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>


  export default {
    props: ['content']
  }
</script>


