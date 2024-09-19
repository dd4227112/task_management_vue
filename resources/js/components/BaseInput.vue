<template>
    <input :type="typeof type === 'undefined' ? 'text' : type" class="form-control" :id="id" :value="modelValue"
        placeholder="Enter your password" @input="updateInput">
</template>

<script setup lang="ts">
defineProps<{
    modelValue?: string,
    type?: string,
    id?: string
}>()
const emit = defineEmits<{
    (event: 'update:modelValue', val: any): void
}>()

function updateInput(event: any) {
    const val = event.target.value
    emit('update:modelValue', val)
}

</script>

<style scoped></style>