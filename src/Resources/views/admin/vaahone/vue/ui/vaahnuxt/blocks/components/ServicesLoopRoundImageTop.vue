<template>
  <div>
    <div class="spacer ServicesLoopRoundImageTop" style="background:rgba(66, 191, 122, 0.18);">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-10 has-text-centered">
            <h2 class="has-text-centered title is-1">{{content.main_heading}}</h2>
            <h6 class="subtitle is-6 has-text-centered">{{content.sub_text}}</h6>
          </div>
        </div>
        <div class="columns m-t-30">
          <!-- column  -->
          <div v-if="content.lang" v-for="lan in content.lang" class="column is-3 m-b-30">
            <div class="columns">
              <div class="column is-12 pro-pic">
                <img :src="lan.src" alt="wrapkit" class="centered-image round-image" style="max-width: 100px;">
              </div>
              <div class="column is-12">
                <div class="p-t-10 has-text-centered">
                  <h5 class="title font-medium">{{lan.heading}}</h5>
                  <p>{{lan.details}}</p>
                </div>
              </div>
            </div>
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


