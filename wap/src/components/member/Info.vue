<template>
  <div class="hello">
    <div>
      <group :title="msg">
        <x-input title="用户名" v-model="loginForm.username"></x-input>
        <x-input title="昵称" v-model="loginForm.name" ></x-input>
        <selector v-model="loginForm.sex" title="性别" :options="plainList" ></selector>
        <x-number title="生日" v-model="loginForm.age"></x-number>
      </group>
      <box gap="10px 10px">
        <divider></divider>
        <el-button type="success" round  v-on:click.native="submitData" class="a-button1">完善信息</el-button>
        <el-button round  v-on:click.native="clearData" class="a-button1">退出登录</el-button>
       </box>
    </div>
    <Foot></Foot>
  </div>
</template>

<script>
import { Selector, Divider, XInput, XNumber, Radio, XButton } from 'vux'
import Foot from '@/components/Foot'
import {
  memberGet,
  memberUpdate
} from '@/api/index'
export default {
  name: 'member',
  components: {
    Selector,
    Divider,
    XInput,
    XNumber,
    Radio,
    Foot,
    XButton
  },
  data () {
    return {
      msg: '让你更加了解你',
      loginForm: [],
      plainList: [{key: 'female', value: '小姐姐'}, {key: 'male', value: '小哥哥'}, {key: 'secret', value: '秘密'}]
    }
  },
  created () {
    memberGet().then((response) => {
      this.loginForm = response.data.data
      console.log(this.loginForm)
    }).catch((error) => {
      console.log(error)
    })
  },
  methods: {
    change (value, label) {
      console.log('change:', value, label)
    },
    submitData: function (event) {
      if (!this.loginForm.username) {
        console.log('用户名不能为空')
      }
      memberUpdate({
        username: this.loginForm.username,
        name: this.loginForm.name,
        age: this.loginForm.age,
        sex: this.loginForm.sex
      }).then((response) => {
        // this.linkTo()
      }).catch((error) => {
        console.log(error)
      })
    },
    clearData () {
      localStorage.clear()
      this.$cookies.remove('token')
      window.location = '#/login'
    },
    linkTo () {
      window.location = '#/activity/bodyDaily'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
p {
  font-weight: normal;
  text-align: center;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
.a-button1 {
    width: 90%;
    margin: 2% 5%;
    display: block;
}
</style>
