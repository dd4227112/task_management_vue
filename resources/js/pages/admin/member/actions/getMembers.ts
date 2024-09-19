import { ref } from "vue"
import { makeAuthorizedHttpRequest } from "../../../../helper/makeAuthorizedHttpRequest"
import { showErrorMessage } from "../../../../helper/util"

export type MemberType={
    id: BigInteger,
    name: string,
    email: string,
    created_at: Date,
    updated_at: Date,

}

export type MembersType = {
    data: {
        data: Array<MemberType> & Record<string, any>
    }
}
export function useGetMember() {
    const loading = ref<boolean>(false)
    const memberData = ref<MembersType>({} as MembersType)
    async function getMembers() {
        try {
            loading.value = true
            const data: any = await makeAuthorizedHttpRequest<undefined, MembersType>('member', 'GET');
            loading.value = false
            memberData.value = data
        } catch (error) {
            loading.value = false
            showErrorMessage(error)
        }

    }
    return { getMembers, memberData, loading }
}