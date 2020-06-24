<template>
 <div class="docs">
   <div class="content">

     <a name="elementtwo" />

     <!--section-heading-->
     <h3><a href="#elementthree" class="title is-3">
       <span class="has-text-primary">#</span>
       Installing Laravel</a>
     </h3>
     <p>Laravel utilizes Composer to manage its dependencies. So, before using Laravel, make sure you have Composer installed on your machine.</p>
     <h5>Via Laravel Installer</h5>
     <p>First, download the Laravel installer using Composer:</p>


     <VhCommand command="composer update"></VhCommand>


     <p>Make sure to place Composer's system-wide vendor bin directory in your <code>$PATH</code> so the laravel executable can be located by your system. This directory exists in different locations based on your operating system; however, some common locations include:</p>
     <ul>
       <li>macOS and GNU / Linux Distributions: <code>$HOME/./vendor/bin</code></li>
       <li>Windows: <code>%USERPROFILE%\AppData\Roaming\Composer\vendor\bin</code></li>
     </ul>

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
