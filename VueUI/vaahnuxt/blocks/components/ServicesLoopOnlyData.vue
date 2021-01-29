<template>
  <div class="spacer">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title is-1">{{content.heading}}</h2>
          <p class="subtitle is-6">{{content.text}}</p>
        </div>
      </div>
      <div class="columns m-t-40">
        <div v-if="content.features" v-for="feature in content.features" class="column is-12 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200">
          <div class="text">
            <h4 class="title is-3">{{feature.heading}}</h4>
            <p class="content">{{feature.details}}</p>
            <ul v-if="feature.list" v-for="item in feature.list">
              <li class="content">{{item.items}}</li>
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


