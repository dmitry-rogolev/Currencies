<template>
    <button @click="$emit('close')" type="button" :class="[ 'btn-close', classes ]" aria-label="Закрыть"></button>
</template>

<script>
    export default {
        name: "QuitComponent", 

        props: [
            "classes", 
        ], 

        computed: {
            theme()
            {
                return this.$store.state.theme;
            }, 
        }, 
    }
</script>

<style>

</style>
