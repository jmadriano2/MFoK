import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import dashboardPage from './components/dashboard/Dashboard.vue'
import loginPage from './components/login/Login.vue'
import errorPage from './components/errors/Errors.vue'
import cobLogPage from './components/coblogs/CobLogs.vue'
import newCobLogPage from './components/coblogs/NewCobLog.vue'
import cobLogDetailsPage from './components/coblogs/CobLogDetails.vue'
import pageNotFound from './components/utility/PageNotFound.vue'
import axios from 'axios'

const routes = [
    {
        path: '/dashboard',
        component: dashboardPage,
        name: 'dashboard',
        beforeEnter: (to, from, next) =>{
            axios.get('/api/authenticated').then(()=>{
                console.log('rekt')
                next()
            }).catch(()=>{
                return next({ name: 'login' })
            })
        }
    },
    {
        path: '/',
        name: 'login',
        component: loginPage
    },
    {
        path: '/errors',
        component: errorPage,
        beforeEnter: (to, from, next) =>{
            axios.get('/api/authenticated').then(()=>{
                next()
            }).catch(()=>{
                return next({ name: 'login' })
            })
        }
    },
    {
        path: '/coblogs',
        component: cobLogPage,
        beforeEnter: (to, from, next) =>{
            axios.get('/api/authenticated').then(()=>{
                next()
            }).catch(()=>{
                return next({ name: 'login' })
            })
        }
    },
    {
        path: '/newcoblog',
        component: newCobLogPage,
        beforeEnter: (to, from, next) =>{
            axios.get('/api/authenticated').then(()=>{
                next()
            }).catch(()=>{
                return next({ name: 'login' })
            })
        }
    },
    {
        path: '/coblog/:id/details',
        component: cobLogDetailsPage,
        name: 'cobLogDetails',
        beforeEnter: (to, from, next) =>{
            axios.get('/api/authenticated').then(()=>{
                next()
            }).catch(()=>{
                return next({ name: 'login' })
            })
        }
    },
    {
        path: '*',
        component: pageNotFound,
        name: 'pageNotFound',
        beforeEnter: (to, from, next) =>{
            axios.get('/api/authenticated').then(()=>{
                next()
            }).catch(()=>{
                return next({ name: 'login' })
            })
        }
    },
]


export default new Router({
    mode: 'history',
    routes
})
