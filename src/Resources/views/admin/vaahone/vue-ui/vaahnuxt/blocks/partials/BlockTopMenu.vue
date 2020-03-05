<template>
  <nav class="navbar zindex" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">

      <nuxt-link to="/ui/blocks" class="navbar-item">
        UI Blocks
      </nuxt-link>


      <a role="button" class="navbar-burger burger" aria-label="menu"
         aria-expanded="false" data-target="navbarUIBlocks">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>

    </div>

    <div id="navbarUIBlocks" class="navbar-menu">
      <div class="navbar-start">

        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            Blocks
          </a>

          <div class="navbar-dropdown">
            <nuxt-link to="/ui/blocks" class="navbar-item">Page 1</nuxt-link>
            <nuxt-link to="/ui/blocks/others" class="navbar-item">Page 2</nuxt-link>
          </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            Cards
          </a>

          <div class="navbar-dropdown">
            <nuxt-link to="/ui/blocks/cards" class="navbar-item">Page 1</nuxt-link>
            <nuxt-link to="/ui/blocks/cards-two" class="navbar-item">Page 2</nuxt-link>
          </div>
        </div>

        <nuxt-link to="/ui/blocks/banner" class="navbar-item">Banner</nuxt-link>
        <nuxt-link to="/ui/blocks/pricing" class="navbar-item">Pricing</nuxt-link>
        <nuxt-link to="/ui/blocks/tabs" class="navbar-item">Tabs & Pills</nuxt-link>
        <nuxt-link to="/ui/blocks/calltoactions" class="navbar-item">Call To Actions</nuxt-link>
        <nuxt-link to="/ui/blocks/forms" class="navbar-item">Forms</nuxt-link>
        <nuxt-link to="/ui/blocks/blogs" class="navbar-item">Blogs</nuxt-link>
        <nuxt-link to="/ui/blocks/clientele" class="navbar-item">Clientele</nuxt-link>
        <nuxt-link to="/ui/blocks/faq" class="navbar-item">FAQ</nuxt-link>
        <nuxt-link to="/ui/blocks/list" class="navbar-item">List</nuxt-link>
        <nuxt-link to="/ui/blocks/testimonials" class="navbar-item">Testimonials</nuxt-link>
        <nuxt-link to="/ui/blocks/counter" class="navbar-item">Counter</nuxt-link>
        <nuxt-link to="/ui/blocks/process" class="navbar-item">Process</nuxt-link>
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            More
          </a>

          <div class="navbar-dropdown">
            <nuxt-link to="/ui/blocks/team" class="navbar-item">Team</nuxt-link>
            <nuxt-link to="/ui/blocks/portfolio" class="navbar-item">Portfolio</nuxt-link>
            <nuxt-link to="/ui/blocks/cheatsheet" class="navbar-item">Cheatsheet</nuxt-link>
          </div>
        </div>



      </div>


    </div>
  </nav>

</template>

<script>
  export default {
    data() {
      return {

      }
    }
  }
</script>
<style>
  .zindex{
    z-index: 10;
  }
  .zindex .navbar-brand{
    font-weight: 700;
    text-transform: uppercase;
  }
</style>
