<template>
  <div>
    <div class="vux-demo">
      <img class="logo" src="../../assets/logo-1.png">
    </div>
    <div>
        <group>
            <x-input title="用户名" v-model="loginForm.username"></x-input>
            <x-input title="密码" v-model="loginForm.password" type="password"></x-input>
        </group>
    </div>
    <x-button type="primary" class="@button-global-border-radius" v-on:click.native="submitData">注册</x-button>
  </div>
</template>

<script>
import { XInput, Calendar, Radio, XButton } from 'vux'
import {
  auths
} from '@/api/index'
export default {
  components: {
    XInput,
    Calendar,
    Radio,
    XButton
  },
  data () {
    return {
      loginForm: {
        username: 'alice',
        password: '111111'
      }
    }
  },
  created () {
    if (this.$cookies.get('token')) {
      this.linkTo()
    }
  },
  methods: {
    submitData: function (event) {
      if (!this.loginForm.username) {
        console.log('用户名不能为空')
      }
      if (!this.loginForm.password) {
        console.log('密码不能为空')
      }
      auths({
        username: this.loginForm.username,
        password: this.loginForm.password
      }).then((response) => {
        console.log(response)
        const token = response.data.data.token
        localStorage.JWT_TOKEN = token
        this.$cookies.set('token', token)
        this.linkTo()
      }).catch((error) => {
        console.log(error)
      })
    },
    linkTo () {
      window.location = '#/activity/bodyDailys'
    }
  }
}
</script>

<style scope>
.vux-demo {
  text-align: center;
}
* { touch-action: pan-y; } 
</style>
