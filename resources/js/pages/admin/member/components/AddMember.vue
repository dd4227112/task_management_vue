<template>
    <div class="card">
        <div class="card-body">
            <form class="forms-sample">

                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';

// const emit = defineEmits<{ (e: 'updateTitle', title: string): void }>();
// const title = 'Members Add';
// onMounted(() => {
//     emit('updateTitle', title)
// })

</script>

<style scoped></style>