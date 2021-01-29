<template>
  <div class="spacer">
    <div class="container">
      <!-- columns  -->
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title">{{content.main_heading}}</h2>
          <h6 class="subtitle">{{content.sub_text}}</h6>
        </div>
      </div>
      <div class="columns text-inverse">
        <div class="column is=7">
          <ul class="columns">
            <li v-if="content.list"
                v-for="(item, index) in content.list" class="column is-6 m-t-30"><span>{{item.items}}</span></li>
          </ul>
        </div>
        <div class="column is-5 has-text-centered">
          <img src="https://via.placeholder.com/400x400" alt="wrappixel" data-aos="fade-up" data-aos-duration="3000" data-aos-offset="500" />
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


