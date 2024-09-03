import { ref } from "vue";
import { makeHttpRequests } from "../../../helper/makeHttpRequest";
import { showMessage } from "../../../helper/toast-notification";
import { showErrorMessage } from "../../../helper/util";

export type LoginInputType = {
    email: string,
    password: string,
}
export type LoginResponseType = {
    isLogin: string,
    token: String
    message: String,
    user: {
        name: string,
        email: string,
        id: string
    }
}
export const LoginInputData = ref<LoginInputType>({} as LoginInputType)

export function useLoginUser() {
    const loading = ref(false)
    async function loginUser() {
        try {
            loading.value = true
            const data:any = await makeHttpRequests<LoginInputType, LoginResponseType>('user/login', 'POST', LoginInputData.value);
            loading.value = false
            console.log(data);
            if (data.isLogin) {
                localStorage.setItem('userData', JSON.stringify(data))
                showMessage(data.message, 'success')
                LoginInputData.value = {} as LoginInputType //clear the input value
                window.location.href = '/dashboard'
            }

        } catch (error) {
            loading.value = false
            showErrorMessage(error)
        }

    }
    return { loginUser, loading }
}