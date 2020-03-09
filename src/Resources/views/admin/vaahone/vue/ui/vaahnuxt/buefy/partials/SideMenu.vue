<template>

  <aside class="menu">
    <p class="menu-label">
      General
    </p>
    <ul class="menu-list">
      <li><router-link to="/buefy/button">Button</router-link></li>
    </ul>

    <p class="menu-label">UI COMPONENTS</p>
    <ul class="menu-list">
      <li><router-link :to="{name: 'bue.index'}">Button</router-link></li>
      <li><router-link :to="{name: 'bue.carousel'}">Carousel</router-link></li>
      <li><router-link to="/buefy/carousel">Carousel</router-link></li>
      <li><router-link to="/buefy/collapse">Collapse</router-link></li>
      <li><router-link to="/buefy/dialog">Dialog</router-link></li>
      <li><router-link to="/buefy/dropdown">Dropdown</router-link></li>
      <li><router-link to="/buefy/icon">Icon</router-link></li>
      <li><router-link to="/buefy/loading">Loading</router-link></li>
      <li><router-link to="/buefy/menu">Menu</router-link></li>
      <li><router-link to="/buefy/message">Message</router-link></li>
      <li><router-link to="/buefy/modal">Modal</router-link></li>
      <li><router-link to="/buefy/navbar">Navbar</router-link></li>
      <li><router-link to="/buefy/notification">Notification</router-link></li>
      <li><router-link to="/buefy/pagination">Pagination</router-link></li>
      <li><router-link to="/buefy/progress">Progress</router-link></li>
      <li><router-link to="/buefy/snackbar">Snackbar</router-link></li>
      <li><router-link to="/buefy/steps">Steps</router-link></li>
      <li><router-link to="/buefy/table">Table</router-link></li>
      <li><router-link to="/buefy/toast">Toast</router-link></li>
      <li><router-link to="/buefy/tooltip">ToolTip</router-link></li>
      <li><router-link to="/buefy/tag">Tag</router-link></li>
      <li><router-link to="/buefy/tabs">Tabs</router-link></li>
    </ul>


    <p class="menu-label">Form Controls</p>
    <ul class="menu-list">
      <li><router-link to="/buefy/formcontrol/autocomplete">Autocomplete</router-link></li>
      <li><router-link to="/buefy/formcontrol/checkbox">Checkbox</router-link></li>
      <li><router-link to="/buefy/formcontrol/clockpicker">Clockpicker</router-link></li>
      <li><router-link to="/buefy/formcontrol/datepicker">Datepicker</router-link></li>
      <li><router-link to="/buefy/formcontrol/datetimepicker">Datetimepicker</router-link></li>
      <li><router-link to="/buefy/formcontrol/field">Field</router-link></li>
      <li><router-link to="/buefy/formcontrol/input">Input</router-link></li>
      <li><router-link to="/buefy/formcontrol/numberinput">Numberinput</router-link></li>
      <li><router-link to="/buefy/formcontrol/radio">Radio</router-link></li>
      <li><router-link to="/buefy/formcontrol/rate">Rate</router-link></li>
      <li><router-link to="/buefy/formcontrol/select">Select</router-link></li>
      <li><router-link to="/buefy/formcontrol/slider">Slider</router-link></li>
      <li><router-link to="/buefy/formcontrol/switch">Switch</router-link></li>
      <li><router-link to="/buefy/formcontrol/taginput">Taginput</router-link></li>
      <li><router-link to="/buefy/formcontrol/timepicker">TimePicker</router-link></li>
      <li><router-link to="/buefy/formcontrol/upload">Upload</router-link></li>
    </ul>

  </aside>

</template>

<script>
  export default {
    data() {
      return {
        isActive: true
      }
    }
  }
</script>
