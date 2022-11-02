<template>
    <label :for="id" v-if="label" class="form-label">
        {{ label }}
    </label>
    <input v-model="value" :class="[ 'form-control', 'form-control-lg', 'bg-light', 'text-dark', 'border-dark', classes ]" :id="id" :aria-describedby="aria" v-bind="$attrs" />
    <small v-if="small" :id="aria" class="form-text text-muted">
        {{ small }}
    </small>
</template>

<script>
    import { id } from "../../lib/helpers";

    export default {
        name: "InputComponent", 

        data()
        {
            return {
                id: id(), 
                aria: id(), 
            };
        }, 

        props: [
            "label", 
            "small", 
            "classes", 
            "modelValue", 
        ], 

        emits: [
            "update:modelValue", 
        ],  

        computed: {
            value: {
                get() {
                    return this.modelValue
                },
                set(value) {
                    this.$emit('update:modelValue', value)
                }
            }
        }
    }
</script>

<style>

</style>
