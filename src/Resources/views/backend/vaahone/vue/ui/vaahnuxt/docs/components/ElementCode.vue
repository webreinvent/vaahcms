<template>
 <div class="docs">
   <div class="content">
     <VhCode language="javascript">
       export default {
       props: ['language'],
       components:{
       },
       data(){

       let obj = {};

       return obj;

       }
       }
     </VhCode>
   </div>
 </div>
</template>

<script>
  import VhCode from "../../resuable/VhCode";

  export default {
    components:{
      VhCode,
    }
  }
</script>
