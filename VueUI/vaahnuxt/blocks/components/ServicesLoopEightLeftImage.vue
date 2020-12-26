<template>
  <div class="spacer">
    <div class="container">
      <div class="columns">
        <div class="column is-5 with-bg pl-0">
          <img :src="content.src" alt="">
        </div>
        <div class="column is-7">
          <div class="with-text pl-5">
            <h2 class="title is-2">{{content.main_heading}}</h2>
            <p class="content">{{content.sub_text}}</p>
            <ul v-if="content.features"
                v-for="feature in content.features" class="list-block m-b-30">
              <li class="content"><span>{{feature.item}}</span></li>
            </ul>
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


