<template>

  <div>
    <div class="spacer feature17">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-7 has-text-centered">
            <h2 class="title is-1">{{content.main_heading}}</h2>
            <h6 class="subtitle is-6">{{content.sub_text}}</h6>
          </div>
        </div>
        <div class="columns is-gapless m-t-40">
          <div v-if="content.services"
               v-for="(service, index) in content.services"  class="column is-4 px-0">
            <div v-if="index%2==0">
              <div class="">
                <div class="has-text-centered">
                  <div class="p-3">
                    <div class="icon-space"><i class="display-5 text-info-gradiant icon-Target"></i></div>
                    <h4 class="title is-4">{{service.heading}}</h4>
                    <p class="content">{{service.details}}</p>
                  </div>
                </div>
              </div>
            </div>
            <div v-else>
              <div class="mb-0">
                <img :src="service.src" class="" alt="wrapkit" />
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
