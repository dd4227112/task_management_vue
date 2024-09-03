<script setup lang="ts">
import { LoginInputData, useLoginUser } from './actions/login';
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
    email: {
        required: helpers.withMessage(requiredMessage, required),
        email: helpers.withMessage(emailMessage, email)
    },
    password: {
        required: helpers.withMessage(requiredMessage, required,),
    },
}

const v$ = useVuelidate(rules, LoginInputData)
const { loading, loginUser } = useLoginUser()
async function login() {
    const result = await v$.value.$validate()
    if (!result) {
        return
    }
    await loginUser()
    // v$.value.$reset() // clear the validation message/rules

}

</script>
<template>
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-3 col-sm-12 "></div>
            <div class="col-xl-6 col-md-6 col-sm-12 border-container">
                <div class="text-center">
                    <h2>Login</h2>
                </div>
                <br>
                <form @submit.prevent="login">
                    <div class="form-group mb-4">
                        <Error :errors="v$.email.$errors" label="Email address" for="email">
                            <BaseInput type="email" id="email" v-model="LoginInputData.email" />
                        </Error>
                    </div>

                    <div class="form-group mb-4">
                        <Error :errors="v$.password.$errors" label="Password" for="Password">
                            <BaseInput type="password" id="Password" v-model="LoginInputData.password" />
                        </Error>
                    </div>
                    <div class="form-group mt-3">
                        <BaseButton name="Login" :loading="loading"/>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <p>Don't have an account? <router-link to="register">Register</router-link></p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-sm-12 "></div>
        </div>
    </div>
</template>

<style scoped></style>