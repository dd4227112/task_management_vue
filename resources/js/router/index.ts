import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/register',
            name: 'register',
            component: () => import('../pages/auth/RegisterPage.vue')
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('../pages/auth/LoginPage.vue'),


        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: () => import('../pages/admin/AdminPage.vue'),
            children: [
                {
                    path: '/dashboard',
                    name: 'dashboard',
                    component: () => import('../pages/admin/Dashboard.vue'),
                },
                {
                    name: 'members',
                    path: '/members',
                    component: () => import('../pages/admin/member/Members.vue'),
                    children: [
                        {
                            name: 'members',
                            path: '/members',
                            component: () => import('../pages/admin/member/components/ListMember.vue'),
                        }
                        ,
                        {
                            name: 'addmember',
                            path: '/members/add',
                            component: () => import('../pages/admin/member/components/AddMember.vue'),
                        }
                    ]
                },
                {
                    name: 'projects',
                    path: '/projects',
                    component: () => import('../pages/admin/project/Projects.vue')
                },
                {
                    name: 'tasks',
                    path: '/tasks',
                    component: () => import('../pages/admin/task/Tasks.vue'),
                }

            ]
        },

    ]
})
export default router;