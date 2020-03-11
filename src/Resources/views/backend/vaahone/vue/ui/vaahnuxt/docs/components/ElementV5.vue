<template>
 <div class="docs">

   <div class="content">

     <a name="elementfive" />

     <!--section-heading-->
     <h3><a href="#elementtwo" class="title is-3">
       <span class="has-text-primary">#</span>
       Server Requirements</a>
     </h3>
     <!--/section-heading-->
     <h3>Environment Variable Types</h3>
     <p>All variables in your <code>.env</code> files are parsed as strings, so some reserved values have been created to allow you to return a wider range of types from the <code>env()</code> function:</p>
     <table>
       <thead>
       <tr>
         <th><code>.env</code> Value</th>
         <th><code>env()</code> Value</th>
       </tr>
       </thead>
       <tbody>
       <tr>
         <td>true</td>
         <td>(bool) true</td>
       </tr>
       <tr>
         <td>(true)</td>
         <td>(bool) true</td>
       </tr>
       <tr>
         <td>false</td>
         <td>(bool) false</td>
       </tr>
       <tr>
         <td>(false)</td>
         <td>(bool) false</td>
       </tr>
       <tr>
         <td>empty</td>
         <td>(string) ''</td>
       </tr>
       <tr>
         <td>(empty)</td>
         <td>(string) ''</td>
       </tr>
       <tr>
         <td>null</td>
         <td>(null) null</td>
       </tr>
       <tr>
         <td>(null)</td>
         <td>(null) null</td>
       </tr>
       </tbody>
     </table>
     <p>If you need to define an environment variable with a value that contains spaces, you may do so by enclosing the value in double quotes.</p>
     <pre><code>APP_NAME="My Application"</code></pre>
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
  const tablerow = '<code>.env</code> Value';
  export default {
    data() {
      return {
        data,
        tablerow,
      }
    }
  }
</script>
