import { ref } from "vue";
import { makeHttpRequests } from "../../../helper/makeHttpRequest";
import { showMessage } from "../../../helper/toast-notification";
import { showErrorMessage } from "../../../helper/util";

export type RegisterInputType = {
    email: string,
    name: string,
    password: string,
    password_confirmation:string
}
export type RegisterResponseType = {
    user: {
        email: String
    },
    message: String
}
export const RegisterInputData = ref<RegisterInputType>({} as RegisterInputType)

export function useRegisterUser() {
    const loading = ref(false)
    async function register() {
        try {
            loading.value = true
            const data:any = await makeHttpRequests<RegisterInputType, RegisterResponseType>('user', 'POST', RegisterInputData.value);
            loading.value = false
            RegisterInputData.value = {} as RegisterInputType //clear the input value
            showMessage(data.message, 'success')
        } catch (error) {
            loading.value = false
            showErrorMessage(error)
        }

    }
    return { register, loading }
}