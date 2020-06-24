<template>
  <nav class="navbar zindex" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">

      <vaah-link to="/ui/bulma" class="navbar-item">
        Bulma Blocks
      </vaah-link>


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

          <vaah-link class="navbar-link" to="/ui/bulma"> Layouts</vaah-link>

          <div class="navbar-dropdown">
            <vaah-link to="/ui/bulma" class="navbar-item">Container</vaah-link>
            <vaah-link to="/ui/bulma/layouts/level" class="navbar-item">Level</vaah-link>
            <vaah-link to="/ui/bulma/layouts/mediaobject" class="navbar-item">Media Object</vaah-link>
            <vaah-link to="/ui/bulma/layouts/hero" class="navbar-item">Hero</vaah-link>
            <vaah-link to="/ui/bulma/layouts/footer" class="navbar-item">Footer</vaah-link>
            <vaah-link to="/ui/bulma/layouts/tiles" class="navbar-item">Tiles</vaah-link>
          </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable">
          <vaah-link class="navbar-link" to="/ui/bulma/forms/general">Form</vaah-link>


          <div class="navbar-dropdown">
            <vaah-link to="/ui/bulma/forms/general" class="navbar-item">General</vaah-link>
            <vaah-link to="/ui/bulma/forms/input" class="navbar-item">Input</vaah-link>
            <vaah-link to="/ui/bulma/forms/textarea" class="navbar-item">Text Area</vaah-link>
            <vaah-link to="/ui/bulma/forms/select" class="navbar-item">Select</vaah-link>
            <vaah-link to="/ui/bulma/forms/checkbox" class="navbar-item">Checkbox</vaah-link>
            <vaah-link to="/ui/bulma/forms/radio" class="navbar-item">Radio Button</vaah-link>
            <vaah-link to="/ui/bulma/forms/file" class="navbar-item">File Upload</vaah-link>
          </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable">
          <vaah-link class="navbar-link" to="/ui/bulma/elements/box">Elements</vaah-link>


          <div class="navbar-dropdown">
            <vaah-link to="/ui/bulma/elements/box" class="navbar-item">Box</vaah-link>
            <vaah-link to="/ui/bulma/elements/button" class="navbar-item">Button</vaah-link>
            <vaah-link to="/ui/bulma/elements/content" class="navbar-item">Content</vaah-link>
            <vaah-link to="/ui/bulma/elements/delete" class="navbar-item">Delete</vaah-link>
            <vaah-link to="/ui/bulma/elements/icon" class="navbar-item">Icon</vaah-link>
            <vaah-link to="/ui/bulma/elements/image" class="navbar-item">Image</vaah-link>
            <vaah-link to="/ui/bulma/elements/notification" class="navbar-item">Notification</vaah-link>
            <vaah-link to="/ui/bulma/elements/progressbar" class="navbar-item">Progress Bar</vaah-link>
            <vaah-link to="/ui/bulma/elements/table" class="navbar-item">Table</vaah-link>
            <vaah-link to="/ui/bulma/elements/tag" class="navbar-item">Tags</vaah-link>
            <vaah-link to="/ui/bulma/elements/title" class="navbar-item">Title</vaah-link>
          </div>
        </div>

        <div class="navbar-item has-dropdown is-hoverable">
          <vaah-link class="navbar-link" to="/ui/bulma/components/breadcrumbs">Components</vaah-link>


          <div class="navbar-dropdown">
            <vaah-link to="/ui/bulma/components/breadcrumbs" class="navbar-item">Breadcrumb</vaah-link>
            <vaah-link to="/ui/bulma/components/cards" class="navbar-item">Card</vaah-link>
            <vaah-link to="/ui/bulma/components/dropdown" class="navbar-item">Dropdown</vaah-link>
            <vaah-link to="/ui/bulma/components/menu" class="navbar-item">Menu</vaah-link>
            <vaah-link to="/ui/bulma/components/message" class="navbar-item">Message</vaah-link>
            <vaah-link to="/ui/bulma/components/modal" class="navbar-item">Modal</vaah-link>
            <vaah-link to="/ui/bulma/components/navbar" class="navbar-item">Navbar</vaah-link>
            <vaah-link to="/ui/bulma/components/pagination" class="navbar-item">Pagination</vaah-link>
            <vaah-link to="/ui/bulma/components/panel" class="navbar-item">Panel</vaah-link>
            <vaah-link to="/ui/bulma/components/tabs" class="navbar-item">Tabs</vaah-link>
          </div>
        </div>



      </div>


    </div>
  </nav>

</template>

<script>
  import globalComponents from '../../helpers/globalComponents'
  export default {
    data() {
      return {

      }
    },
    components:{
      ...globalComponents,
    },
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
