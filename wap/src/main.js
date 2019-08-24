// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Axios from 'axios'
import Qs from 'qs'
import FastClick from 'fastclick'
import VueRouter from 'vue-router'
import App from './App'
import VueCookies from 'vue-cookies'
import router from './router'

import {
  AjaxPlugin,
  Group
} from 'vux'

Vue.use(VueCookies)
Vue.use(AjaxPlugin)
Vue.use(VueRouter)

Vue.prototype.$axios = Axios
Vue.prototype.qs = Qs

Vue.component('group', Group)

FastClick.attach(document.body)

Vue.config.productionTip = false

Axios.interceptors.request.use(
  config => {
    if (localStorage.JWT_TOKEN) { // 判断是否存在token，如果存在的话，则每个http header都加上token
      config.headers.Authorization = `token ${localStorage.JWT_TOKEN}`
    }
    return config
  },
  err => {
    return Promise.reject(err)
  }
)
/* eslint-disable no-new */
new Vue({
  router,
  render: h => h(App)
}).$mount('#app-box')
