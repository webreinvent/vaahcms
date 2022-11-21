<template>
  <DataTable :value="customers" :paginator="true" :rows="10"
             dataKey="id" :rowHover="true" v-model:selection="selectedCustomers" v-model:filters="filters" filterDisplay="menu"
             paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[10,25,50]"
             currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
             :globalFilterFields="['name','country.name','representative.name','status']" responsiveLayout="scroll">
    <template #header>
      <div class="flex justify-content-between align-items-center">
        <h5 class="m-0">Customers</h5>
        <span class="p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                            </span>
      </div>
    </template>
    <template #empty>
      No customers found.
    </template>
    <Column selectionMode="multiple" style="min-width: 3rem"></Column>
    <Column field="name" header="Name" sortable style="min-width: 14rem">
      <template #body="{data}">
        {{data.name}}
      </template>
      <template #filter="{filterModel}">
        <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by name"/>
      </template>
    </Column>
    <Column field="country.name" header="Country" sortable filterMatchMode="contains" style="min-width: 14rem">
      <template #body="{data}">
        <img src="demo/images/flag_placeholder.png" :class="'flag flag-' + data.country.code" width="30" />
        <span class="image-text">{{data.country.name}}</span>
      </template>
      <template #filter="{filterModel}">
        <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by country"/>
      </template>
    </Column>
    <Column header="Agent" sortable filterField="representative" sortField="representative.name" :showFilterMatchModes="false" :filterMenuStyle="{'width':'14rem'}" style="min-width: 14rem">
      <template #body="{data}">
        <img :alt="data.representative.name" :src="'demo/images/avatar/' + data.representative.image" width="32" style="vertical-align: middle" />
        <span class="image-text">{{data.representative.name}}</span>
      </template>
      <template #filter="{filterModel}">
        <div class="mb-3 font-bold">Agent Picker</div>
        <MultiSelect v-model="filterModel.value" :options="representatives" optionLabel="name" placeholder="Any" class="p-column-filter">
          <template #option="slotProps">
            <div class="p-multiselect-representative-option">
              <img :alt="slotProps.option.name" :src="'demo/images/avatar/' + slotProps.option.image" width="32" style="vertical-align: middle" />
              <span class="image-text">{{slotProps.option.name}}</span>
            </div>
          </template>
        </MultiSelect>
      </template>
    </Column>
    <Column field="date" header="Date" sortable dataType="date" style="min-width: 8rem">
      <template #body="{data}">
        {{formatDate(data.date)}}
      </template>
      <template #filter="{filterModel}">
        <Calendar v-model="filterModel.value" dateFormat="mm/dd/yy" placeholder="mm/dd/yyyy" />
      </template>
    </Column>
    <Column field="balance" header="Balance" sortable dataType="numeric" style="min-width: 8rem">
      <template #body="{data}">
        {{formatCurrency(data.balance)}}
      </template>
      <template #filter="{filterModel}">
        <InputNumber v-model="filterModel.value" mode="currency" currency="USD" locale="en-US" />
      </template>
    </Column>
    <Column field="status" header="Status" sortable :filterMenuStyle="{'width':'14rem'}" style="min-width: 10rem">
      <template #body="{data}">
        <span :class="'customer-badge status-' + data.status">{{data.status}}</span>
      </template>
      <template #filter="{filterModel}">
        <Dropdown v-model="filterModel.value" :options="statuses" placeholder="Any" class="p-column-filter" :showClear="true">
          <template #value="slotProps">
            <span :class="'customer-badge status-' + slotProps.value">{{slotProps.value}}</span>
          </template>
          <template #option="slotProps">
            <span :class="'customer-badge status-' + slotProps.option">{{slotProps.option}}</span>
          </template>
        </Dropdown>
      </template>
    </Column>
    <Column field="activity" header="Activity" sortable :showFilterMatchModes="false" style="min-width: 10rem">
      <template #body="{data}">
        <ProgressBar :value="data.activity" :showValue="false" />
      </template>
      <template #filter="{filterModel}">
        <Slider v-model="filterModel.value" range class="m-3"></Slider>
        <div class="flex align-items-center justify-content-between px-2">
          <span>{{filterModel.value ? filterModel.value[0] : 0}}</span>
          <span>{{filterModel.value ? filterModel.value[1] : 100}}</span>
        </div>
      </template>
    </Column>
    <Column headerStyle="min-width: 4rem; text-align: center" bodyStyle="text-align: center; overflow: visible">
      <template #body>
        <Button type="button" icon="pi pi-cog"></Button>
      </template>
    </Column>
  </DataTable>
</template>
<script>
import {FilterMatchMode, FilterOperator} from "primevue/api";
import CountryService from "../../../service/CountryService";
import CustomerService from "../../../service/CustomerService";
import CountriesData from "../../../assets/data/country.json";
import CustomerData from "../../../assets/data/customers-large.json";

export default {
  name:'DataTableComponent',
  data(){
    return{
      customers: CustomerData.data,
      selectedCustomers: null,
      filters: {
        'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
        'name': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
        'country.name': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
        'representative': {value: null, matchMode: FilterMatchMode.IN},
        'date': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.DATE_IS}]},
        'balance': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.EQUALS}]},
        'status': {operator: FilterOperator.OR, constraints: [{value: null, matchMode: FilterMatchMode.EQUALS}]},
        'activity': {value: null, matchMode: FilterMatchMode.BETWEEN},
        'verified': {value: null, matchMode: FilterMatchMode.EQUALS}
      },
    }
  },
  created() {

  },
  mounted() {

  },
  methods:{
    formatDate(value) {
      return value.toLocaleString('en-US', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
      });
    },
    formatCurrency(value) {
      return value.toLocaleString('en-US', {style: 'currency', currency: 'USD'});
    }
  }
}
</script>
