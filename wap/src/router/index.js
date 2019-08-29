import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/components/HelloFromVux'
import Hello from '@/components/HelloWorld'
import Login from '@/components/Login/Index'

import Member from '@/components/Member/Info'
import AddBodyDaily from '@/components/Activity/AddBodyDaily'
import BodyDaily from '@/components/Activity/BodyDaily'

import {
  checkLogin
} from '@/api/index'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: Home,
      beforeEnter: (to, from, next) => {
        var token = this.$cookies.get('token')
        if (token) {
          checkLogin().then((res) => {
            if (res.data.errorCode === 0) {
              next()
            } else {
              window.location = '/login'
            }
          })
        }
      }
    },
    {
      path: '/vue', component: Hello
    },
    {
      path: '/login', component: Login
    },
    {
      path: '/member', component: Member
    },
    {
      path: '/activity/bodyDailys', component: BodyDaily
    },
    {
      path: '/activity/bodyDaily', component: AddBodyDaily
    },
    {
      path: '/test', component: Member
    }
  ]
})
