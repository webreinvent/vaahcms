<template>
  <div class="ServiceFeaturesNumbersTopThreeColumns">
    <div class="container is-fullhd">
      <div class="columns">
        <div v-if="content.features" v-for="(feature, index) in content.features" class="column is-4 border-right">
          <h1 v-if="index<=8" class="has-text-centered feature-number mt-3">0{{index+1}}</h1><h1 v-else-if="index>8" class="has-text-centered feature-number mt-3">{{index+1}}</h1>
          <h3 class="has-text-centered mt-3 title is-3">{{feature.heading}}</h3>
          <p class="has-text-centered content">{{feature.details}}</p>
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


