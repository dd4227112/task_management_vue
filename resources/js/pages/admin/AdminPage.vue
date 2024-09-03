<template>
    <div class="container-scroller">
        <NavBar />
        <div class="container-fluid page-body-wrapper">
            <SideBar />
            <div class="main-panel">
                <div class="content-wrapper">
                 <RouterView></RouterView>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import NavBar from './NavBar.vue';
import SideBar from './SideBar.vue';
</script>


<style scoped></style>