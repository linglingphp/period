<template>
  <div class="hello">
    <p>{{ msg }}</p>
    <p>{{ desc }}</p>
    <div>
      <group>
        <x-input title="用户名" v-model="loginForm.username"></x-input>
        <x-input title="密码" v-model="loginForm.password" type="password"></x-input>
      </group>
    </div>
  </div>
</template>

<script>
import { XInput, Calendar, Radio, XButton } from 'vux'
import {
  memberGet,
  memberUpdate
} from '@/api/index'
export default {
  name: 'HelloWorld',
  components: {
    XInput,
    Calendar,
    Radio,
    XButton
  },
  data () {
    return {
      msg: '欢迎来到了解身体活动',
      desc: '请完善信息',
      loginForm: []
    }
  },
  created () {
    memberGet().then((response) => {
      this.loginForm = response.data
      console.log(this.loginForm)
    }).catch((error) => {
      console.log(error)
    })
  },
  methods: {
    submitData: function (event) {
      if (!this.loginForm.username) {
        console.log('用户名不能为空')
      }
      if (!this.loginForm.password) {
        console.log('密码不能为空')
      }
      memberUpdate({
        username: this.loginForm.username,
        password: this.loginForm.password
      }).then((response) => {
        const token = response.data.data.token
        this.$cookies.set('token', token)
        this.linkTo()
      }).catch((error) => {
        console.log(error)
      })
    },
    linkTo () {
      window.location = '#/vue'
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
