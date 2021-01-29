<template>
  <div class="spacer ServicesBigColorBoxes">
    <div class="container is-fullhd">
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title is-1">{{content.main_heading}}</h2>
          <h6 class="subtitle is-6">{{content.sub_text}}</h6>
        </div>
      </div>
      <div class="columns is-gapless">
        <!-- column  -->
        <div v-if="content.features"
             v-for="(feature,index) in content.features" class="column is-4">
          <div v-if="index%3==0" class="has-text-centered p-10 bg-megna has-text-white">
            <div class="display-4 m-b-20"><img v-if="feature.src" class="round-image" :src="feature.src" alt=""></div>
            <h4 class="title is-4 has-text-white">{{feature.heading}}</h4>
            <p class="content has-text-white">{{feature.details}}</p>
          </div>
          <div v-else-if="index%3==1" class="has-text-centered p-10 has-background-primary has-text-white">
            <div class="display-4 m-b-20"><img v-if="feature.src" class="round-image" :src="feature.src" alt=""></div>
            <h4 class="title is-4 has-text-white">{{feature.heading}}</h4>
            <p class="content has-text-white">{{feature.details}}</p>
          </div>
          <div v-else-if="index%3==2" class="has-text-centered p-10 bg-orange has-text-white">
            <div class="display-4 m-b-20"><img v-if="feature.src" class="round-image" :src="feature.src" alt=""></div>
            <h4 class="title is-4 has-text-white">{{feature.heading}}</h4>
            <p class="content has-text-white">{{feature.details}}</p>
          </div>
        </div>
        <!-- column  -->
      </div>
    </div>
  </div>
</template>

<script>


  export default {
    props: ['content']
  }
</script>


