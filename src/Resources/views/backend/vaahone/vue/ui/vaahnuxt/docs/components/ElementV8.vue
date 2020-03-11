<template>
 <div class="docs">
   <div class="content">

     <a name="elementeight" />

     <!--section-heading-->
     <h3><a href="#elementtwo" class="title is-3">
       <span class="has-text-primary">#</span>
       Other Valet Commands</a>
     </h3>
     <!--/section-heading-->
     <b-table :data="data">
       <template slot-scope="props">
         <b-table-column field="Command" label="Command">
           <code>{{ props.row.Command }}</code>
         </b-table-column>
         <b-table-column field="Description" label="Description">
           {{ props.row.Description }}
         </b-table-column>
       </template>
     </b-table>
     <b-message type="is-info" has-icon>
       Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id fermentum quam. Proin sagittis, nibh id hendrerit imperdiet, elit sapien laoreet elit
     </b-message>
   </div>
 </div>
</template>

<script>
  const data = [
    {"Command":'valet forget',"Description":'Run this command from a "parked" directory to remove it from the parked directory list.'},
    {"Command":'valet forget',"Description":'Run this command from a "parked" directory to remove it from the parked directory list.'},
    {"Command":'valet forget',"Description":'Run this command from a "parked" directory to remove it from the parked directory list.'},
    {"Command":'valet forget',"Description":'Run this command from a "parked" directory to remove it from the parked directory list.'},
    {"Command":'valet forget',"Description":'Run this command from a "parked" directory to remove it from the parked directory list.'},
    {"Command":'valet forget',"Description":'Run this command from a "parked" directory to remove it from the parked directory list.'},
    {"Command":'valet forget',"Description":'Run this command from a "parked" directory to remove it from the parked directory list.'},
  ];
  export default {
    data() {
      return {
        data,
      }
    }
  }
</script>
