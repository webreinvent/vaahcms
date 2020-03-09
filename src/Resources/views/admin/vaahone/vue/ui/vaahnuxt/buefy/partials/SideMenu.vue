<template>

  <aside class="menu">
    <p class="menu-label">
      General
    </p>
    <ul class="menu-list">
      <li><vaah-link to="/ui/buefy/button">Button</vaah-link></li>
    </ul>

    <p class="menu-label">UI COMPONENTS</p>
    <ul class="menu-list">
      <li><vaah-link to="/ui/buefy/button">Button</vaah-link></li>
      <li><vaah-link to="/ui/buefy/carousel">Carousel</vaah-link></li>
      <li><vaah-link to="/ui/buefy/collapse">Collapse</vaah-link></li>
      <li><vaah-link to="/ui/buefy/dialog">Dialog</vaah-link></li>
      <li><vaah-link to="/ui/buefy/dropdown">Dropdown</vaah-link></li>
      <li><vaah-link to="/ui/buefy/icon">Icon</vaah-link></li>
      <li><vaah-link to="/ui/buefy/loading">Loading</vaah-link></li>
      <li><vaah-link to="/ui/buefy/menu">Menu</vaah-link></li>
      <li><vaah-link to="/ui/buefy/message">Message</vaah-link></li>
      <li><vaah-link to="/ui/buefy/modal">Modal</vaah-link></li>
      <li><vaah-link to="/ui/buefy/navbar">Navbar</vaah-link></li>
      <li><vaah-link to="/ui/buefy/notification">Notification</vaah-link></li>
      <li><vaah-link to="/ui/buefy/pagination">Pagination</vaah-link></li>
      <li><vaah-link to="/ui/buefy/progress">Progress</vaah-link></li>
      <li><vaah-link to="/ui/buefy/snackbar">Snackbar</vaah-link></li>
      <li><vaah-link to="/ui/buefy/steps">Steps</vaah-link></li>
      <li><vaah-link to="/ui/buefy/table">Table</vaah-link></li>
      <li><vaah-link to="/ui/buefy/toast">Toast</vaah-link></li>
      <li><vaah-link to="/ui/buefy/tooltip">ToolTip</vaah-link></li>
      <li><vaah-link to="/ui/buefy/tag">Tag</vaah-link></li>
      <li><vaah-link to="/ui/buefy/tabs">Tabs</vaah-link></li>
    </ul>


    <p class="menu-label">Form Controls</p>
    <ul class="menu-list">
      <li><vaah-link to="/ui/buefy/formcontrol/autocomplete">Autocomplete</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/checkbox">Checkbox</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/clockpicker">Clockpicker</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/datepicker">Datepicker</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/datetimepicker">Datetimepicker</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/field">Field</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/input">Input</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/numberinput">Numberinput</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/radio">Radio</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/rate">Rate</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/select">Select</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/slider">Slider</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/switch">Switch</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/taginput">Taginput</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/timepicker">TimePicker</vaah-link></li>
      <li><vaah-link to="/ui/buefy/formcontrol/upload">Upload</vaah-link></li>
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
