<template>
    <section :class="[ 'modal', 'fade', classes ]" tabindex="-1" :aria-labelledby="id" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div :class="[ 'modal-content', 'bg-light', 'border-light', 'text-dark' ]" style="border-radius: 15px;">
                <div class="modal-header border-secondary border-bottom-0">
                    <h4 class="modal-title mb-0" :id="id">
                        {{ title }}
                    </h4>
                    <QuitComponent @close="$emit('close')" />
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer border-top-0">
                    <CloseComponent @close="$emit('close')" />
                    <SaveComponent @save="$emit('save')" />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import QuitComponent from "./QuitComponent.vue";
    import CloseComponent from "./CloseComponent.vue";
    import SaveComponent from "./SaveComponent.vue";
    import { id } from "../../lib/helpers";

    export default {
        name: "WindowComponent", 

        components: {
            QuitComponent, 
            CloseComponent, 
            SaveComponent, 
        }, 

        props: {
            classes: String, 
            title: String, 
        }, 

        data()
        {
            return {
                id: id(), 
            };
        }, 
    }
</script>

<style>

</style>
