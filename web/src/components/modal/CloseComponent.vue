<template>
    <button @click="$emit('close')" type="button" :class="[ 'btn', 'btn-secondary', classes ]" aria-label="Закрыть">
        Закрыть
    </button>
</template>

<script>
    export default {
        name: "CloseComponent", 

        props: [
            "classes", 
        ], 
    }
</script>

<style>

</style>
