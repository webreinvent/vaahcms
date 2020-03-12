<template>

<!--sections-->
<section class="section">
    <div class="container has-text-centered">
        Aside Menu
    </div>
</section>
<!--sections-->

</template>

<script>



export default {
    computed:{
        root() {return this.$store.getters['root/state']},
    },
    components:{

    }
}

</script>

