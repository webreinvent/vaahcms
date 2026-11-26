<template>
  <h5>Timeline</h5>
  <Timeline :value="timelineEvents" align="alternate">
    <template #content="slotProps">
      {{slotProps.item.status}}
    </template>
  </Timeline>
</template>

<script>
export default {
  name: "TimelineComponent",
  data(){
    return{
      timelineEvents: [
        /* M7-T4 — the four raw Material-palette literals are off the app's
           token system, so each now carries the scheme-aware token of the
           same hue role (accent / info / warn / success). Note: the installed
           OpenVue Timeline renders only the `#content` slot (status text) —
           `color` / `icon` / `date` / `image` are demo data the engine does
           not currently paint (the v3 colored markers were dropped by the
           engine swap, not by this change); the values are kept and made
           token-legal so a future marker port is a data-only edit. */
        {status: 'Ordered', date: '15/10/2020 10:30', icon: 'pi pi-shopping-cart', color: 'var(--p-primary-color)', image: 'game-controller.jpg'},
        {status: 'Processing', date: '15/10/2020 14:00', icon: 'pi pi-cog', color: 'var(--p-button-info-background)'},
        {status: 'Shipped', date: '15/10/2020 16:15', icon: 'pi pi-shopping-cart', color: 'var(--p-button-warn-background)'},
        {status: 'Delivered', date: '16/10/2020 10:00', icon: 'pi pi-check', color: 'var(--p-button-success-background)'}
      ]
    }
  }
}
</script>

<style scoped>

</style>