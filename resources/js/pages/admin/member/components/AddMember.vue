<template>
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" @submit.prevent="addNewMember">
                <div class="form-group">
                    <Error :errors="v$.name.$errors" label="Full Name" for="name">
                        <BaseInput type="text" id="name" v-model="MemberInputData.name" placeholder="Enter full name" />
                    </Error>
                </div>
                <div class="form-group">
                    <Error :errors="v$.email.$errors" label="Email Address" for="email">
                        <BaseInput type="email" id="email" v-model="MemberInputData.email"
                            placeholder="Enter your email" />
                    </Error>
                </div>
                <BaseButton name="Save" :loading="loading" />
            </form>
        </div>
    </div>
</template>
<script setup lang="ts">
import { MemberInputData, useAddMember } from '../actions/addmember';
import { useVuelidate } from '@vuelidate/core'
import { required, email, helpers } from '@vuelidate/validators'
import Error from '../../../../components/Error.vue';
import BaseButton from '../../../../components/BaseButton.vue';
import BaseInput from '../../../../components/BaseInput.vue';


// const rules = {
//     name: { required }, 
//     email: { required, email }, 
//     password: { required },

// }

// Create custom validation messages
const requiredMessage = 'You must fill this input'
const emailMessage = 'Please enter a valid email address'

// Use withMessage to add custom messages to validators
const rules = {
    name: {
        required: helpers.withMessage(requiredMessage, required,),
    },
    email: {
        required: helpers.withMessage(requiredMessage, required),
        email: helpers.withMessage(emailMessage, email)
    },
   
}

const v$ = useVuelidate(rules, MemberInputData)
const { loading, AddMember } = useAddMember()
async function addNewMember() {
    const result = await v$.value.$validate()
    if (!result) {
        return
    }
    await AddMember()
    // v$.value.$reset() // clear the validation message/rules

}

</script>

<style scoped></style>