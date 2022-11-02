<template>
    <ButtonComponent :target="id" :title="title" :classes="buttonClasses" v-bind="$attrs">
        <slot name="button"></slot>
    </ButtonComponent>
    <WindowComponent @save="$emit('save')" @close="close" :id="id" :title="header" :classes="windowClasses">
        <slot name="window"></slot>
    </WindowComponent>
</template>

<script>
    import ButtonComponent from "./modal/ButtonComponent.vue";
    import WindowComponent from "./modal/WindowComponent.vue";
    import { id } from "../lib/helpers";

    export default {
        name: "ModalComponent", 

        components: {
            ButtonComponent, 
            WindowComponent, 
        }, 

        props: [
            "title", 
            "header", 
            "buttonClasses", 
            "windowClasses", 
        ], 

        data()
        {
            return {
                id: id(), 
            };
        }, 

        methods: {
            show()
            {
                this.$bootstrap.Modal.getInstance(document.getElementById(this.id)).show();
            }, 

            close()
            {
                this.$bootstrap.Modal.getInstance(document.getElementById(this.id)).hide();
            }, 
        }, 
    }
</script>

<style>

</style>
