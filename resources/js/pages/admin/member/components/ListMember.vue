<template>
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-6">
                    <form action="">
                        <BaseInput type="text" placeholder="search...." />
                    </form>
                </div>
                <div class="col-6">
                    <RouterLink to="members/add" class="btn btn-sm btn-primary float-end">Add Member</RouterLink>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> #</th>
                            <th> Avatar </th>
                            <th> Full name </th>
                            <th> Email</th>
                            <th> Action </th>
                            <th> </th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loading">
                            <td colspan="6" class="">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr v-else v-for="member in memberData?.data?.data" :key="member.id">
                            <td> {{ member.id }} </td>
                            <td class="py-1">
                                <img src="../../../../../js/src/assets/images/faces-clipart/pic-1.png" alt="image" />
                            </td>
                            <td> {{ member.name }} </td>
                            <td> {{ member.email }}</td>
                            <td><button class="btn btn-sm btn-success"
                                    @click="emit('updateMember', member)">Edit</button>
                            </td>
                            <td><button @click="emit('deleteMember', member)"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { MemberType, useGetMember } from '../actions/getMembers';
import BaseInput from '../../../../components/BaseInput.vue';
const { getMembers, memberData, loading } = useGetMember()
async function listMembers() {
    await getMembers();
}


onMounted(async () => {
    listMembers()
})
const emit = defineEmits<{
    (e: 'updateMember', member: MemberType): void,
    (e: 'deleteMember', id: MemberType): void
}>()

</script>

<style scoped></style>