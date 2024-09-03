<template>
    <button :disabled  = "loading" class="btn btn-primary w-25 ">
        <span v-if="!loading">{{ name }}</span>
        <div v-if="loading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </button>

</template>

<script setup lang="ts">
defineProps<{
    name: string,
    loading: boolean
}>()
</script>

<style scoped></style>