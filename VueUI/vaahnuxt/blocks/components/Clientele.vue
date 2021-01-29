<template>
  <div class="has-background-light Clientele spacer">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title">{{content.main_heading}}</h2>
          <h6 class="subtitle">{{content.sub_text}}</h6>
        </div>
      </div>
      <div class="columns">
        <div v-if="content.list"
             v-for="item in content.list" class="column is-3">
          <div class="bordered">
            <img :src="item.src" class="centered-image" alt="">
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
