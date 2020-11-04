import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import dashboardPage from './components/dashboard/Dashboard.vue'
import errorPage from './components/errors/Errors.vue'
import cobLogPage from './components/coblogs/CobLogs.vue'

const routes = [
    {
        path: '/',
        component: dashboardPage
    },
    {
        path: '/errors',
        component: errorPage
    },
    {
        path: '/coblogs',
        component: cobLogPage
    },
]


export default new Router({
    mode: 'history',
    routes
})