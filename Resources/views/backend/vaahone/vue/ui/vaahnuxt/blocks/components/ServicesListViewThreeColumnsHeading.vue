<template>
  <div class="spacer">
    <div class="container">
      <div class="columns is-centered">
        <div v-if="content.main_heading" class="column is-10 has-text-centered my-5">
          <h4 class="title">{{content.main_heading}}</h4>
          <p>{{content.sub_text}}</p>
        </div>
        <div v-if="content.list" v-for="item in content.list" class="column is-4">
          <ul>
            <li>{{item.items}}</li>
          </ul>
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


