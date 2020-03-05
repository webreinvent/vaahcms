<template>
 <div class="docs">
   <div class="content">
     <a name="elementtwo" />

     <!--section-heading-->
     <h3><a href="#elementfour" class="title is-3">
       <span class="has-text-primary">#</span>
       Environment Configuration</a>
     </h3>
     <p>It is often helpful to have different configuration values based on the environment where the application is running. For example, you may wish to use a different cache driver locally than you do on your production server.</p>
     <p>To make this a cinch, Laravel utilizes the <a href="https://github.com/vlucas/phpdotenv">DotEnv</a> PHP library by Vance Lucas. In a fresh Laravel installation, the root directory of your application will contain a <code>.env.example</code> file. If you install Laravel via Composer, this file will automatically be renamed to <code>.env</code>. Otherwise, you should rename the file manually.</p>
     <p>Your <code>.env</code> file should not be committed to your application's source control, since each developer / server using your application could require a different environment configuration. Furthermore, this would be a security risk in the event an intruder gains access to your source control repository, since any sensitive credentials would get exposed.</p>
     <p>If you are developing with a team, you may wish to continue including a <code>.env.example</code> file with your application. By putting placeholder values in the example configuration file, other developers on your team can clearly see which environment variables are needed to run your application. You may also create a <code>.env.testing</code> file. This file will override the <code>.env</code> file when running PHPUnit tests or executing Artisan commands with the <code>--env=testing</code> option.</p>
     <blockquote>
       <div class="callout"><div class="icon purple"><img src="http://via.placeholder.com/120x120"></div><p class="content"> Any variable in your <code>.env</code> file can be overridden by external environment variables such as server-level or system-level environment variables.</p></div>
     </blockquote>
   </div>
 </div>
</template>
