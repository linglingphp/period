import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/components/HelloFromVux'
import Hello from '@/components/HelloWorld'
import Login from '@/components/Login/Index'

import Member from '@/components/Member/Info'
import Foot from '@/components/Foot'
import AddBodyDaily from '@/components/Activity/AddBodyDaily'
import BodyDaily from '@/components/Activity/BodyDaily'
import StatisticPower from '@/components/Statistic/Power'

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
      path: '/foot', component: Foot
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
      path: '/statistic/power', component: StatisticPower
    },
    {
      path: '/test', component: Member
    }
  ]
})
