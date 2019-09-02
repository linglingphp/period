// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Axios from 'axios'
import Qs from 'qs'
import FastClick from 'fastclick'
import VueRouter from 'vue-router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import App from './App'
import VueCookies from 'vue-cookies'
import router from './router'

import {
  Tabbar,
  TabbarItem,
  AjaxPlugin,
  Group
} from 'vux'

Vue.use(VueCookies)
Vue.use(AjaxPlugin)
Vue.use(VueRouter)
Vue.use(ElementUI)

Vue.prototype.$axios = Axios
Vue.prototype.qs = Qs

Vue.component('Tabbar', Tabbar)
Vue.component('TabbarItem', TabbarItem)
Vue.component('group', Group)

FastClick.attach(document.body)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  router,
  render: h => h(App)
}).$mount('#app-box')
