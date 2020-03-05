<template>
  <div class="spacer ServiceLoopFive">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-10 has-text-centered">
          <h2 class="title is-1">{{content.main_heading}}</h2>
          <h6 class="subtitle is-6">{{content.sub_text}}</h6>
        </div>
      </div>
      <div class="columns is-gapless">
        <div v-if="content.services"
             v-for="(service, index) in content.services" class="column is-6">
          <div v-if="index%2==0 && index < content.services.length - 2" class="b-r b-b p-3">
            <div class="align-self-center">
              <h5 class="title is-3">{{service.heading}}</h5>
              <p class="content">{{service.details}}</p>

              <ul v-if="service.list"
                  v-for="items in service.list">
                <li class="content">{{items.item}}</li>
              </ul>
            </div>
          </div>
          <div v-else-if="index%2!=0 && index < content.services.length - 1" class="b-b p-3">
            <div class="align-self-center">
              <h5 class="title is-3">{{service.heading}}</h5>
              <p class="content">{{service.details}}</p>

              <ul v-if="service.list"
                  v-for="items in service.list">
                <li class="content">{{items.item}}</li>
              </ul>
            </div>
          </div>
          <div v-if="index%2==0 && index == content.services.length - 2" class="b-r p-3">
            <div class="align-self-center">
              <h5 class="title is-3">{{service.heading}}</h5>
              <p class="content">{{service.details}}</p>

              <ul v-if="service.list"
                  v-for="items in service.list">
                <li class="content">{{items.item}}</li>
              </ul>
            </div>
          </div>
          <div v-if="index%2!=0 && index == content.services.length - 1" class="p-3">
            <div class="align-self-center">
              <h5 class="title is-3">{{service.heading}}</h5>
              <p class="content">{{service.details}}</p>

              <ul v-if="service.list"
                  v-for="items in service.list">
                <li class="content">{{items.item}}</li>
              </ul>
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


