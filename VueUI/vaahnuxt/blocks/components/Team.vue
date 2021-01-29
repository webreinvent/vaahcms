<template>
  <div>
    <div class="spacer team4">
      <div class="container">
        <div class="columns is-centered m-b-30">
          <div class="column is-7 has-text-centered">
            <h2 class="title">{{content.heading}}</h2>
            <h6 class="subtitle">{{content.details}}</h6>
          </div>
        </div>
        <div class="columns m-t-30">
          <!-- column  -->
          <div v-if="content.team" v-for="member in content.team" class="column is-3 m-b-30">
            <!-- columns -->
            <div class="columns">
              <div class="column is-12 pro-pic">
                <img :src="member.src" alt="wrapkit" class="img-responsive">
              </div>
              <div class="column is-12">
                <div class="p-t-10">
                  <h5 class="title font-medium">{{member.name}}</h5>
                  <h6 class="subtitle">{{member.designation}}</h6>
                  <p>{{member.details}}</p>
                  <ul v-if="member.list" class="list-inline">
                    <li v-for="cls in member.list" class="list-inline-item"><a href="#"><i :class="cls.class"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- columns -->
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

