<template>
    <div :class="[ 'd-flex', classes ]">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "FlexComponent", 

        props: [
            "classes", 
        ], 
    }
</script>

<style>

</style>
