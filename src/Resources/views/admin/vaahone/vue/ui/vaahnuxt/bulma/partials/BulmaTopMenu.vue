<template>
  <nav class="navbar zindex" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">

      <router-link to="/ui/bulma" class="navbar-item">
        Bulma Blocks
      </router-link>


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

          <router-link class="navbar-link" to="/ui/bulma"> Layouts</router-link>

          <div class="navbar-dropdown">
            <router-link to="/ui/bulma" class="navbar-item">Container</router-link>
            <router-link to="/ui/bulma/layouts/level" class="navbar-item">Level</router-link>
            <router-link to="/ui/bulma/layouts/mediaobject" class="navbar-item">Media Object</router-link>
            <router-link to="/ui/bulma/layouts/hero" class="navbar-item">Hero</router-link>
            <router-link to="/ui/bulma/layouts/footer" class="navbar-item">Footer</router-link>
            <router-link to="/ui/bulma/layouts/tiles" class="navbar-item">Tiles</router-link>
          </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable">
          <router-link class="navbar-link" to="/ui/bulma/forms/general">Form</router-link>


          <div class="navbar-dropdown">
            <router-link to="/ui/bulma/forms/general" class="navbar-item">General</router-link>
            <router-link to="/ui/bulma/forms/input" class="navbar-item">Input</router-link>
            <router-link to="/ui/bulma/forms/textarea" class="navbar-item">Text Area</router-link>
            <router-link to="/ui/bulma/forms/select" class="navbar-item">Select</router-link>
            <router-link to="/ui/bulma/forms/checkbox" class="navbar-item">Checkbox</router-link>
            <router-link to="/ui/bulma/forms/radio" class="navbar-item">Radio Button</router-link>
            <router-link to="/ui/bulma/forms/file" class="navbar-item">File Upload</router-link>
          </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable">
          <router-link class="navbar-link" to="/ui/bulma/elements/box">Elements</router-link>


          <div class="navbar-dropdown">
            <router-link to="/ui/bulma/elements/box" class="navbar-item">Box</router-link>
            <router-link to="/ui/bulma/elements/button" class="navbar-item">Button</router-link>
            <router-link to="/ui/bulma/elements/content" class="navbar-item">Content</router-link>
            <router-link to="/ui/bulma/elements/delete" class="navbar-item">Delete</router-link>
            <router-link to="/ui/bulma/elements/icon" class="navbar-item">Icon</router-link>
            <router-link to="/ui/bulma/elements/image" class="navbar-item">Image</router-link>
            <router-link to="/ui/bulma/elements/notification" class="navbar-item">Notification</router-link>
            <router-link to="/ui/bulma/elements/progressbar" class="navbar-item">Progress Bar</router-link>
            <router-link to="/ui/bulma/elements/table" class="navbar-item">Table</router-link>
            <router-link to="/ui/bulma/elements/tag" class="navbar-item">Tags</router-link>
            <router-link to="/ui/bulma/elements/title" class="navbar-item">Title</router-link>
          </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable">
          <router-link class="navbar-link" to="/ui/bulma/components/breadcrumbs">Components</router-link>


          <div class="navbar-dropdown">
            <router-link to="/ui/bulma/components/breadcrumbs" class="navbar-item">Breadcrumb</router-link>
            <router-link to="/ui/bulma/components/cards" class="navbar-item">Card</router-link>
            <router-link to="/ui/bulma/components/dropdown" class="navbar-item">Dropdown</router-link>
            <router-link to="/ui/bulma/components/menu" class="navbar-item">Menu</router-link>
            <router-link to="/ui/bulma/components/message" class="navbar-item">Message</router-link>
            <router-link to="/ui/bulma/components/modal" class="navbar-item">Modal</router-link>
            <router-link to="/ui/bulma/components/navbar" class="navbar-item">Navbar</router-link>
            <router-link to="/ui/bulma/components/pagination" class="navbar-item">Pagination</router-link>
            <router-link to="/ui/bulma/components/panel" class="navbar-item">Panel</router-link>
            <router-link to="/ui/bulma/components/tabs" class="navbar-item">Tabs</router-link>
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
