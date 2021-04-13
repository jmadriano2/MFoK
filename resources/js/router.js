import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import dashboardPage from './components/dashboard/Dashboard.vue'
import loginPage from './components/login/Login.vue'
import errorPage from './components/errors/Errors.vue'
import cobLogPage from './components/coblogs/CobLogs.vue'
import newCobLogPage from './components/coblogs/NewCobLog.vue'
import cobLogDetailsPage from './components/coblogs/CobLogDetails.vue'

const routes = [
    {
        path: '/dashboard',
        component: dashboardPage
    },
    {
        path: '/',
        name: 'login',
        component: loginPage
    },
    {
        path: '/errors',
        component: errorPage
    },
    {
        path: '/coblogs',
        component: cobLogPage
    },
    {
        path: '/newcoblog',
        component: newCobLogPage
    },
    {
        path: '/coblog/:id/details',
        name: 'cobLogDetails',
        component: cobLogDetailsPage
    },
]


export default new Router({
    mode: 'history',
    routes
})
