<template>
    <label :for="props.for" class="form-label">{{ props.label }}</label>
    <div :class="{ error: props.errors.length }"></div>
    <slot></slot>
    <div class="text-danger" v-for="error of props.errors" :key="error.$uid">
        <div class="error-msg">{{ error.$message }}</div>
    </div>
</template>

<script setup lang="ts">
import { ErrorObject } from '@vuelidate/core';

const props = defineProps<{
    errors: ErrorObject[],
    for:string
    label: string
}>()

</script>

<style scoped></style>