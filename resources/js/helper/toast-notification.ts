
import { useToast } from 'vue-toast-notification';
// import 'vue-toast-notification/dist/theme-sugar.css';

const toast = useToast();

// export function showErrorMessage(message: string) {
//     toast.error(message, {
//         position: 'bottom-right',
//         duration: 4000,
//         dismissible: true,
//     })
// }

export function showMessage(message: string, type:string) {
    toast.success(message, {
        type:type,
        position: type=='error'?'top':'top-right',
        duration: 3000,
        dismissible: true,
        pauseOnHover:true
    })
}