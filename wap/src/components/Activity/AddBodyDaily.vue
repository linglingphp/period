<template>
  <div class="hello">
    <div class="msg">{{ msg }}</div>
    
    <group>
      <div class="form">
      <group>
        <calendar title="日期" v-model="loginForm.date" @click.native="onChange" show-popup-header></calendar>
        <x-input title="体重" v-model="loginForm.weight" text-align="right"></x-input>
        <x-input title="精力" v-model="loginForm.spirit" text-align="right"></x-input>
        <x-input title="体力" v-model="loginForm.power" text-align="right"></x-input>
        <x-input title="颜值" v-model="loginForm.beauty" text-align="right"></x-input>
        <!-- <cell title="精力" :inline-desc="'分: '+loginForm.spirit" primary="content">
          <range v-model="loginForm.spirit" :min="min" :max="max" :step="step"></range>
        </cell>
        <cell title="体力" :inline-desc="'分: '+loginForm.power" primary="content">
          <range v-model="loginForm.power" :min="min" :max="max" :step="step"></range>
        </cell>
        <cell title="颜值" :inline-desc="'分: '+loginForm.beauty" primary="content">
          <range v-model="loginForm.beauty" :min="min" :max="max" :step="step"></range>
        </cell> -->
        <x-input title="梦" v-model="loginForm.dream_type" text-align="right" ></x-input>
        <cell title="饮水量">
          <inline-x-number style="display:block;" v-model="loginForm.water" :min="1000" :step="100" width="50px" button-style="round"></inline-x-number>
        </cell>
        <x-switch title="是否锻炼" v-model="loginForm.is_exercise"></x-switch>
        <x-textarea title="锻炼" v-model="loginForm.exercise"></x-textarea>
        <x-textarea title="食物" v-model="loginForm.food"></x-textarea>
        <cell title="便便次数">
          <inline-x-number style="display:block;" v-model="loginForm.shit_time" :min="0" width="50px" button-style="round"></inline-x-number>
        </cell>
        <x-input title="便便体验" v-model="loginForm.shit_type" text-align="right" ></x-input>
      </group>
      <x-button type="primary" class="@button-global-border-radius" v-on:click.native="submitData">提交记录</x-button>
    </div>
    </group>
    <tabbar>
      <tabbar-item show-dot is-link :link="{ path: 'bodyDailys' }">
        <span class="el-icon-s-home" slot="label"></span>
      </tabbar-item>
      <tabbar-item show-dot is-link :link="{ path: '../member' }">
        <span class="el-icon-s-custom" slot="label"></span>
      </tabbar-item>
    </tabbar>
  </div>
</template>

<script>
import { Range, InlineXSwitch, XSwitch, Loading, Actionsheet, Toast, querystring, Cell, XInput, Calendar, Radio, XButton, InlineXNumber, XTextarea } from 'vux'
import {
  bodyDailyGet,
  bodyDailyAdd
} from '@/api/index'
export default {
  name: 'bodyDaily',
  components: {
    Range,
    InlineXSwitch,
    XSwitch,
    Loading,
    Actionsheet,
    Toast,
    querystring,
    Cell,
    XInput,
    Calendar,
    Radio,
    XButton,
    InlineXNumber,
    XTextarea
  },
  data () {
    return {
      msg: '你今日份数据',
      min: 0,
      max: 120,
      step: 5,
      loginForm: []
    }
  },
  created () {
    const date = this.$route.query['date']
    bodyDailyGet(date).then((response) => {
      this.loginForm = response.data.data
    }).catch((error) => {
      console.log(error)
    })
  },
  methods: {
    submitData: function (event) {
      bodyDailyAdd({
        date: this.loginForm.date,
        weight: this.loginForm.weight,
        spirit: this.loginForm.spirit,
        power: this.loginForm.power,
        shit_time: this.loginForm.shit_time,
        shit_type: this.loginForm.shit_type,
        dream_type: this.loginForm.dream_type,
        water: this.loginForm.water,
        is_exercise: this.loginForm.is_exercise,
        exercise: this.loginForm.exercise,
        beauty: this.loginForm.beauty,
        food: this.loginForm.food
      }).then((response) => {
        window.location = '#/activity/bodyDailys'
      }).catch((error) => {
        console.log(error)
      })
    },
    linkTo () {
      window.location = '#/activity'
    },
    onChange (val) {
      console.log('on change', val)
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
.weui-tabbar {
  position: fixed !important;
}
.form {
    margin-bottom: 100px;
}
</style>
