<template>

<!--sections-->
<section class="section">
    <div class="container has-text-centered">
        <Copyright/>
    </div>
</section>
<!--sections-->

</template>

<script>

import Copyright from "./Copyright";

export default {
    computed:{
        root() {return this.$store.getters['root/state']},
    },
    components:{
        Copyright,
    }
}

</script>

