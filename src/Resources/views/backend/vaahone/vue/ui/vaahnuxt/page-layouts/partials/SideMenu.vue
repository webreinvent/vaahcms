<template>
  <aside class="menu">
    <p class="menu-label">
      General
    </p>
    <ul class="menu-list">
      <li><vaah-link to="/ui/buefy/button">Button</vaah-link></li>
    </ul>
    <p class="menu-label">Form Controls</p>
    <ul class="menu-list">
      <li><vaah-link to="/ui/buefy/button">Button</vaah-link></li>
    </ul>

  </aside>
</template>

<script>
  import globalComponents from '../../helpers/globalComponents'
  export default {
    data() {
      return {
        isActive: true
      }
    },
    components:{
      ...globalComponents,
    },
  }
</script>
