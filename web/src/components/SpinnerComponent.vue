<template>
    <FlexComponent classes="justify-content-center">
        <div :class="[ 'spinner-border', classes ]" role="status" v-bind="$attrs">
            <span class="visually-hidden">Загрузка...</span>
        </div>
    </FlexComponent>
</template>

<script>
    export default {
        name: "SinnerComponent", 

        props: [
            "classes", 
        ], 
    };
</script>

<style scoped>

</style>
