<template>
  <div class="hello">
    <p>{{ msg }}</p>
    <p>{{ desc }}</p>
    <div>
      <group>
        <x-input title="用户名" v-model="loginForm.username"></x-input>
        <x-input title="昵称" v-model="loginForm.name" ></x-input>
        <radio title="性别" :options="radio01" :value="loginForm.sex" @on-change="change"></radio>
        <calendar title="生日" v-model="loginForm.birthday"></calendar>
      </group>
      <x-button type="primary" class="@button-global-border-radius" v-on:click.native="submitData">完善信息</x-button>
    </div>
    <tabbar>
      <tabbar-item show-dot is-link :link="{ path: 'activity/bodyDailys' }">
        <img slot="icon" src="../../assets/logo-1.png">
        <span slot="label">首页</span>
      </tabbar-item>
      <tabbar-item show-dot is-link :link="{ path: '../member' }">
        <img slot="icon" src="../../assets/logo-1.png">
        <span slot="label">我的</span>
      </tabbar-item>
    </tabbar>
  </div>
</template>

<script>
import { XInput, Calendar, Radio, XButton } from 'vux'
import {
  memberGet,
  memberUpdate
} from '@/api/index'
export default {
  name: 'member',
  components: {
    XInput,
    Calendar,
    Radio,
    XButton
  },
  data () {
    return {
      msg: '欢迎来到了解你自己',
      desc: '请完善信息',
      loginForm: [],
      radio01: [{
        key: 'female',
        value: '小姐姐'
      }, {
        key: 'male',
        value: '小哥哥'
      }, {
        key: 'scret',
        value: '不告诉你'
      }]
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
        brithday: this.loginForm.brithday,
        sex: this.loginForm.sex
      }).then((response) => {
        this.linkTo()
      }).catch((error) => {
        console.log(error)
      })
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
</style>
