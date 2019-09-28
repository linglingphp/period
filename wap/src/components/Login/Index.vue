<template>
  <div>
    <div class="vux-demo">
      <img class="logo" src="../../assets/logo-1.png">
      <p id="show">{{ msg }}</p>

    </div>
    <div class="a-form">
      <el-input placeholder="请输入用户名" v-model="loginForm.username" clearable class="a-input"></el-input>
      <el-input placeholder="请输入密码" v-model="loginForm.password" show-password  class="a-input"></el-input>
    </div>
      <el-button type="primary" round v-on:click.native="submitData" class="a-button">登录</el-button>
  </div>
</template>

<script>
import { Calendar, Radio, XButton } from 'vux'
import {
  auths
} from '@/api/index'
export default {
  components: {
    Calendar,
    Radio,
    XButton
  },
  data () {
    var msg = '生活不止眼前的苟且，还有远方的苟且……'
    return {
      msg,
      loginForm: {
        username: '',
        password: ''
      }
    }
  },
  created () {
    const that = this
    var story = that.msg
    var i = 0
    var timer = setInterval(function () {
      i++
      that.msg = story.substr(0, i)
      console.log(that.msg)
      if (that.msg === story) {
        clearInterval(timer)
      }
    }, 300)
    this.msg = that.msg
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
#show{
  text-align: center;
}
.vux-demo {
    background: #000;
    height: 15em;
    color: #fff;
}
.a-input{
  width: 80%;
  margin: 4% 10% 0 10%;
}
.a-button {
    margin: 4% 10%;
    width: 80%;
    background-color: #000;
}
</style>
