<template>
    <button @click="$emit('show')" type="button" :class="['btn', classes]" data-bs-toggle="modal" :data-bs-target="'#' + target">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        name: "ButtonComponent", 

        props: [
            "classes", 
            "target", 
        ], 
    }
</script>

<style>

</style>
