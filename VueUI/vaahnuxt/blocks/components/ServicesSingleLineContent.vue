<template>
  <div class="ServicesSingleLineContent">
    <div class="spacer feature24">
      <div class="container">
        <!-- columns -->
        <div class="columns is-centered">
          <div class="column is-7 has-text-centered">
            <h2 class="title">{{content.main_heading}}</h2>
            <h6 class="subtitle">{{content.sub_text}}</h6>
          </div>
        </div>
        <!-- columns -->
        <div class="columns wrap-feature-24">
          <!-- Column -->
          <div v-if="content.list"
               v-for="item in content.list" class="column is-4-desktop column is-6-tablet is-centered">
            <div class="card card-shadow">
              <a class="service-24"> <i class="icon-Target"></i>
                <h6 class="ser-title">{{item.items}}</h6>
              </a>
            </div>
          </div>
          <!-- Column -->
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
