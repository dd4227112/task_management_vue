<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item nav-profile" >
                <a href="#" class="nav-link">
                    <div class="nav-profile-image">
                        <img src="../../src/assets/images/faces/face1.jpg" alt="profile">
                        <span class="login-status offiline"></span>
                        <!--change to offline or busy as needed-->
                    </div>
                    <div class="nav-profile-text d-flex flex-column">
                        <span class="font-weight-bold mb-2">David Grey. H</span>
                        <span class="text-secondary text-small">Project Manager</span>
                    </div>
                    <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                </a>
            </li>
            <li class="nav-item" v-for="sidebar in sidebars" :key="sidebar.name">
                <RouterLink class="nav-link" :to="sidebar.path">
                    <span class="menu-title">{{  sidebar.name }}</span>
                    <i :class="sidebar.icon"></i>
                </RouterLink>
            </li>
        </ul>
    </nav>
</template>

<script setup lang="ts">
import { sidebars } from '../../helper/util';

console.log(sidebars);

</script>

<style scoped></style>