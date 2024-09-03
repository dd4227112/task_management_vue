<script setup lang="ts">
import { RegisterInputData, useRegisterUser } from './actions/register';
import { useVuelidate } from '@vuelidate/core'
import { required, email, helpers } from '@vuelidate/validators'
import Error from '../../components/Error.vue';
import BaseInput from '../../components/BaseInput.vue';
import BaseButton from '../../components/BaseButton.vue';


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
        required: helpers.withMessage(requiredMessage, required)
    },
    email: {
        required: helpers.withMessage(requiredMessage, required),
        email: helpers.withMessage(emailMessage, email)
    },
    password: {
        required: helpers.withMessage(requiredMessage, required,),
    },
}

const v$ = useVuelidate(rules, RegisterInputData)
const { loading, register } = useRegisterUser()
async function submitRegister() {
    const result = await v$.value.$validate()
    if (!result) {
        return
    }
    await register()
    v$.value.$reset() // clear the validation message/rules

}

</script>
<template>
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-3 col-sm-12 "></div>
            <div class="col-xl-6 col-md-6 col-sm-12 border-container">
                <div class="text-center">
                    <h2>Register</h2>
                </div>
                <br>
                <form @submit.prevent="submitRegister">
                    <div class="form-group mb-4">
                        <Error :errors="v$.name.$errors" label="Full Name" for="Name">
                            <BaseInput type="text" id="Name" v-model="RegisterInputData.name"
                                placeholder="Enter full name" />

                        </Error>

                    </div>
                    <div class="form-group mb-4">
                        <Error :errors="v$.email.$errors" label="Email address" for="email">
                            <BaseInput type="email" id="email" v-model="RegisterInputData.email" />
                        </Error>
                    </div>

                    <div class="form-group mb-4">
                        <Error :errors="v$.password.$errors" label="Password" for="Password">
                            <BaseInput type="password" id="Password" v-model="RegisterInputData.password" />
                        </Error>
                    </div>

                    <div class="form-group mb-4">
                        <Error :errors="[]" label="Confirm Password" for="confirmPassword">
                            <BaseInput type="password" id="confirmPassword" v-model="RegisterInputData.password_confirmation"
                                placeholder="Confirm your password" />
                        </Error>
                    </div>
                    <div class="form-group mt-3">
                        <BaseButton name="Register" :loading="loading"/>
                        
                    </div>
                </form>
                <div class="text-center mt-3">
                    <p>Already have an account? <router-link to="login">Login</router-link></p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-sm-12 "></div>
        </div>
    </div>
</template>

<style scoped></style>