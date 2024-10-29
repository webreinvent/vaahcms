<template>
  <h5>Overlay Panel</h5>
  <Button type="button" label="Choose" @click="toggle" icon="pi pi-search" />
  <OverlayPanel ref="op" appendTo="body" :showCloseIcon="true" style="width: 450px">
    <DataTable :value="products" v-model:selection="selectedProduct" selectionMode="single" :paginator="true" :rows="5" @row-select="onProductSelect">
      <Column field="name" header="Name" sortable></Column>
      <Column header="Image">
        <template #body="slotProps">
          <img :src="'demo/images/product/' + slotProps.data.image" :alt="slotProps.data.image" class="product-image" />
        </template>
      </Column>
      <Column field="price" header="Price" sortable>
        <template #body="slotProps">
          {{formatCurrency(slotProps.data.price)}}
        </template>
      </Column>
    </DataTable>
  </OverlayPanel>
</template>

<script>
import productsData from "../../../assets/data/products-small.json";

export default {
  name: "OverlayPanelComponent",
  created() {
  },
  mounted() {
  },
  data(){
    return{
      products: productsData.data,
      selectedProduct: null,
    }
  },
  methods:{
    onProductSelect(event) {
      this.$refs.op.hide();
      this.$toast.add({severity:'info', summary: 'Product Selected', detail: event.data.name, life: 3000});
    },
    toggle(event) {
      this.$refs.op.toggle(event);
    },
    formatCurrency(value) {
      return value.toLocaleString('en-US', {style: 'currency', currency: 'USD'});
    }
  }
}
</script>

<style scoped>
.product-image {
  width: 50px;
  box-shadow: 0 3px 6px rgba(0,0,0,.16), 0 3px 6px rgba(0,0,0,.23);
}
</style>
