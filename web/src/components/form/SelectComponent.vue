<template>
    <label v-if="label" :for="id" class="form-label">
        {{ label }}
    </label>
    <select v-model="value" :id="label" :class="[ 'form-select', classes ]" :aria-label="label" v-bind="$attrs">
        <slot></slot>
    </select>
</template>

<script>
    import { id } from "../../lib/helpers";

    export default {
        name: "SelectComponent", 

        props: [
            "classes", 
            "label", 
            "modelValue", 
        ], 

        data()
        {
            return {
                id: id(), 
            };
        }, 

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
