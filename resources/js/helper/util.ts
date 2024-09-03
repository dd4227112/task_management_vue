import { ref } from "vue";
import { showMessage } from "./toast-notification";

export function showErrorMessage(error: unknown) {
    if (Array.isArray(error)) {
        for (const message of error as string[]) {
            showMessage(message, 'error');
        }
    } else {
        showMessage((error as Error).message, 'error');
    }
}
type sidebarType =
    {
        name: string,
        path: string,
        icon: string
    }[];


export const sidebars = ref<sidebarType>([
    {
        name: 'Members',
        path: '/members',
        icon: 'mdi mdi-contacts menu-icon'
    },
    {
        name: 'Projects',
        path: '/projects',
        icon: 'mdi mdi-medical-bag menu-icon'
    },
    {
        name: 'Tasks',
        path: '/tasks',
        icon: 'mdi mdi-chart-bar menu-icon'
    }
]);