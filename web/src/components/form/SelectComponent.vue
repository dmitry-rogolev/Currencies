<template>
    <label v-if="label" :for="id" class="form-label">
        {{ label }}
    </label>
    <select v-model="selected" @change="$emit('update:modelValue', selected)" :id="label" :class="[ 'form-select', classes ]" :aria-label="label" v-bind="$attrs">
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
                selected: this.modelValue, 
            };
        }, 

        emits: [
            "update:modelValue", 
        ],
    }
</script>

<style>

</style>
