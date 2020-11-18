<template>
  <div class="banner">
    <div class="container is-fullhd">
      <img :src="content.src">
    </div>
  </div>
</template>

<script>


  export default {
    props: ['content']
  }
</script>


