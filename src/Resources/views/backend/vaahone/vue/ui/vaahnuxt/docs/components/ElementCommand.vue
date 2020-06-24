<template>
 <div class="docs">

   <div class="content">
     <VhCommand command="composer update"></VhCommand>
   </div>

 </div>
</template>

<script>
  import VhCommand from "../../resuable/VhCommand";
  export default {
    components:{
      VhCommand,
    }
  }
</script>
