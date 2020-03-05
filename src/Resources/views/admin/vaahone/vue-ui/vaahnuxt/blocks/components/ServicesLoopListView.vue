<template>
  <div class="spacer">
    <div class="has-background-light">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-7 has-text-centered">
            <h2 class="title">{{content.main_heading}}</h2>
            <h6 class="subtitle">{{content.sub_text}}</h6>
          </div>
        </div>
        <div class="columns m-t-40">
          <div v-if="content.list" v-for="item in content.list" class="column is-4">
            <ul>
              <li>{{item.items}}</li>
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


