<template>
    <div class="copyright-text">
        <Copyright/>
    </div>
</template>

<script>
import Copyright from "./Copyright.vue";
export default {
    computed:{
        root() {return this.$store.getters['root/state']},
    },
    components:{
        Copyright,
    }
}
</script>

