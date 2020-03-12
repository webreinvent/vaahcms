<template>

<!--sections-->
<div class="aside">
    Aside Menu
</div>
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

