<template>
 <div class="docs">

   <aside class="menu">
     <div class="menu-container">
       <b-collapse :open="false">
         <a class="has-text-dark"
           slot="trigger"><b>Eloquent ORM</b></a>
         <div class="content menu-list">
           <ul  class="link-items">
             <li>
               <a href="#" class="has-text-dark">Request Lifecycle</a>
             </li>
             <li>
               <a href="#" class="has-text-dark">Service Container</a>
             </li>
             <li>
               <a href="#" class="has-text-dark">Service Providers</a>
             </li>
             <li>
               <a href="#" class="has-text-dark">Contracts</a>
             </li>
             <li>
               <a href="#" class="has-text-dark">Facades</a>
             </li>
           </ul>
         </div>
       </b-collapse>
     </div>

     <div class="menu-container">
       <b-collapse :open="false" >
         <a class="has-text-dark"
           slot="trigger"><b>Getting Started</b></a>
         <div class="content menu-list">
           <ul  class="link-items">
             <li>
               <a href="#" class="has-text-dark">Installation</a>
             </li>
             <li>
               <a href="#" class="has-text-dark">Configuration</a>
             </li>
             <li>
               <a href="#" class="has-text-dark">Directory Structure</a>
             </li>
             <li>
               <a href="#" class="has-text-dark">Homestead</a>
             </li>
             <li>
               <a href="#" class="has-text-dark">Valet</a>
             </li>
             <li>
               <a href="#" class="has-text-dark">Deployment</a>
             </li>
           </ul>
         </div>
       </b-collapse>
     </div>
   </aside>

 </div>
</template>

<script>
  export default {

  }
</script>
