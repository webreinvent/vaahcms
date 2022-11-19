<template>
<div>
  <h5>Buttons</h5>
  <Button label="Submit" class="mr-2 mb-2" />
  <Button icon="pi pi-check" class="mr-2 mb-2" />
  <Button label="Submit" icon="pi pi-check" class="mr-2 mb-2" />
  <Button label="Submit" icon="pi pi-check" iconPos="right" class="mr-2 mb-2" />
  <Button label="Disabled" disabled="disabled" class="mr-2 mb-2" />

  <h5>Severities</h5>
  <Button label="Primary" class="mr-2 mb-2" />
  <Button label="Secondary" class="p-button-secondary mr-2 mb-2" />
  <Button label="Success" class="p-button-success mr-2 mb-2" />
  <Button label="Info" class="p-button-info mr-2 mb-2" />
  <Button label="Warning" class="p-button-warning mr-2 mb-2" />
  <Button label="Help" class="p-button-help mr-2 mb-2" />
  <Button label="Danger" class="p-button-danger mr-2 mb-2" />
  <Button label="Plain" class="p-button-plain mb-2" />

  <h5>Raised Buttons</h5>
  <Button label="Primary" class="p-button-raised mr-2 mb-2" />
  <Button label="Secondary" class="p-button-raised p-button-secondary mr-2 mb-2" />
  <Button label="Success" class="p-button-raised p-button-success mr-2 mb-2" />
  <Button label="Info" class="p-button-raised p-button-info mr-2 mb-2" />
  <Button label="Warning" class="p-button-raised p-button-warning mr-2 mb-2" />
  <Button label="Help" class="p-button-raised p-button-help mr-2 mb-2" />
  <Button label="Danger" class="p-button-raised p-button-danger mr-2 mb-2" />
  <Button label="Plain" class="p-button-raised p-button-plain mb-2" />

  <h5>Rounded Buttons</h5>
  <Button label="Primary" class="p-button-rounded mr-2 mb-2" />
  <Button label="Secondary" class="p-button-rounded p-button-secondary mr-2 mb-2" />
  <Button label="Success" class="p-button-rounded p-button-success mr-2 mb-2" />
  <Button label="Info" class="p-button-rounded p-button-info mr-2 mb-2" />
  <Button label="Warning" class="p-button-rounded p-button-warning mr-2 mb-2" />
  <Button label="Help" class="p-button-rounded p-button-help mr-2 mb-2" />
  <Button label="Danger" class="p-button-rounded p-button-danger mr-2 mb-2" />
  <Button label="Plain" class="p-button-rounded p-button-plain mb-2" />

  <h5>Text Buttons</h5>
  <Button label="Primary" class="p-button-text mr-2 mb-2" />
  <Button label="Secondary" class="p-button-secondary p-button-text mr-2 mb-2" />
  <Button label="Success" class="p-button-success p-button-text mr-2 mb-2" />
  <Button label="Info" class="p-button-info p-button-text mr-2 mb-2" />
  <Button label="Warning" class="p-button-warning p-button-text mr-2 mb-2" />
  <Button label="Help" class="p-button-help p-button-text mr-2 mb-2" />
  <Button label="Danger" class="p-button-danger p-button-text mr-2 mb-2" />
  <Button label="Plain" class="p-button-text p-button-plain mb-2" />

  <h5>Raised Text Buttons</h5>
  <Button label="Primary" class="p-button-raised p-button-text mr-2 mb-2" />
  <Button label="Secondary" class="p-button-raised p-button-secondary p-button-text mr-2 mb-2" />
  <Button label="Success" class="p-button-raised p-button-success p-button-text mr-2 mb-2" />
  <Button label="Info" class="p-button-raised p-button-info p-button-text mr-2 mb-2" />
  <Button label="Warning" class="p-button-raised p-button-warning p-button-text mr-2 mb-2" />
  <Button label="Help" class="p-button-raised p-button-help p-button-text mr-2 mb-2" />
  <Button label="Danger" class="p-button-raised p-button-danger p-button-text mr-2 mb-2" />
  <Button label="Plain" class="p-button-raised p-button-plain p-button-text mb-2" />

  <h5>Outlined Buttons</h5>
  <Button label="Primary" class="p-button-outlined mr-2 mb-2" />
  <Button label="Secondary" class="p-button-outlined p-button-secondary mr-2 mb-2" />
  <Button label="Success" class="p-button-outlined p-button-success mr-2 mb-2" />
  <Button label="Info" class="p-button-outlined p-button-info mr-2 mb-2" />
  <Button label="Warning" class="p-button-outlined p-button-warning mr-2 mb-2" />
  <Button label="Help" class="p-button-outlined p-button-help mr-2 mb-2" />
  <Button label="Danger" class="p-button-outlined p-button-danger mr-2 mb-2" />
  <Button label="Plain" class="p-button-outlined p-button-plain mb-2" />

  <h5>Rounded Icon Buttons</h5>
  <Button icon="pi pi-check" class="p-button-rounded mr-2 mb-2" />
  <Button icon="pi pi-bookmark" class="p-button-rounded p-button-secondary mr-2 mb-2" />
  <Button icon="pi pi-search" class="p-button-rounded p-button-success mr-2 mb-2" />
  <Button icon="pi pi-user" class="p-button-rounded p-button-info mr-2 mb-2" />
  <Button icon="pi pi-bell" class="p-button-rounded p-button-warning mr-2 mb-2" />
  <Button icon="pi pi-heart" class="p-button-rounded p-button-help mr-2 mb-2" />
  <Button icon="pi pi-times" class="p-button-rounded p-button-danger mb-2" />

  <h5>Rounded Text Icon Buttons</h5>
  <Button icon="pi pi-check" class="p-button-rounded p-button-text mr-2 mb-2" />
  <Button icon="pi pi-bookmark" class="p-button-rounded p-button-secondary p-button-text mr-2 mb-2" />
  <Button icon="pi pi-search" class="p-button-rounded p-button-success p-button-text mr-2 mb-2" />
  <Button icon="pi pi-user" class="p-button-rounded p-button-info p-button-text mr-2 mb-2" />
  <Button icon="pi pi-bell" class="p-button-rounded p-button-warning p-button-text mr-2 mb-2" />
  <Button icon="pi pi-heart" class="p-button-rounded p-button-help p-button-text mr-2 mb-2" />
  <Button icon="pi pi-times" class="p-button-rounded p-button-danger p-button-text mr-2 mb-2" />

  <h5>Rounded and Outlined Icon Buttons</h5>
  <Button icon="pi pi-check" class="p-button-rounded p-button-outlined mr-2 mb-2" />
  <Button icon="pi pi-bookmark" class="p-button-rounded p-button-secondary p-button-outlined mr-2 mb-2" />
  <Button icon="pi pi-search" class="p-button-rounded p-button-success p-button-outlined mr-2 mb-2" />
  <Button icon="pi pi-user" class="p-button-rounded p-button-info p-button-outlined mr-2 mb-2" />
  <Button icon="pi pi-bell" class="p-button-rounded p-button-warning p-button-outlined mr-2 mb-2" />
  <Button icon="pi pi-heart" class="p-button-rounded p-button-help p-button-outlined mr-2 mb-2" />
  <Button icon="pi pi-times" class="p-button-rounded p-button-danger p-button-outlined mb-2" />

  <h5>Badges</h5>
  <Button type="button" label="Emails" badge="8" class="mr-2 mb-2" />
  <Button type="button" label="Messages" icon="pi pi-users" class="p-button-warning mb-2" badge="8" badgeClass="p-badge-danger" />

  <h5>Sizes</h5>
  <div class="sizes">
    <Button label="Small" icon="pi pi-check" class="p-button-sm mr-2 mb-2"  />
    <Button label="Normal" icon="pi pi-check" class="p-button mr-2 mb-2"  />
    <Button label="Large" icon="pi pi-check" class="p-button-lg mr-2 mb-2" />
  </div>

  <h5>Button Set</h5>
  <span class="p-buttonset">
                    <Button label="Save" icon="pi pi-check" />
                    <Button label="Delete" icon="pi pi-trash" />
                    <Button label="Cancel" icon="pi pi-times" />
            </span>
  <LightButtons class="mt-5"/>

</div>
</template>

<script>
import LightButtons from "./LightButtons.vue";
export default {
  name: "ButtonsComponent",
  components: {LightButtons}
}
</script>

<style scoped>

</style>