<template>
    <button @click="$emit('save')" type="button" :class="[ 'btn', 'btn-primary', classes ]">
        Сохранить
    </button>
</template>

<script>
    export default {
        name: "SaveComponent", 

        props: [
            "classes", 
        ], 
    }
</script>

<style>

</style>
