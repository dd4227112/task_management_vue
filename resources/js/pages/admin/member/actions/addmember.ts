import { ref } from "vue";
import { makeAuthorizedHttpRequest } from "../../../../helper/makeAuthorizedHttpRequest";
import { showMessage } from "../../../../helper/toast-notification";
import { showErrorMessage } from "../../../../helper/util";

export type MemberInputType = {
    email: string,
    name: string,
}
export type MemberResponseType = {
    message: String
}
export const MemberInputData = ref<MemberInputType>({} as MemberInputType)

export function useAddMember() {
    const loading = ref<boolean>(false)
    async function AddMember() {
        try {
            loading.value = true
            const data: any = await makeAuthorizedHttpRequest<MemberInputType, MemberResponseType>('member', 'POST', MemberInputData.value);
            loading.value = false
            MemberInputData.value = {} as MemberInputType //clear the input value
            showMessage(data.message, 'success')
            //  window.location.href = '/members'
        } catch (error) {
            loading.value = false
            showErrorMessage(error)
        }

    }
    return { AddMember, loading }
}