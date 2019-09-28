<template>
  <div class="hello">
    <group :title="msg" class="form">
        <calendar title="日期" v-model="loginForm.date" @click.native="onChange" ></calendar>
        <x-input title="体重" v-model="loginForm.weight" placeholder="你真的不重呢"></x-input>
        <cell title="精力">
          <inline-x-number style="display:block;" v-model="loginForm.spirit" :min="70" :step="5" width="50px" button-style="round"></inline-x-number>
        </cell>
        <cell title="体力">
          <inline-x-number style="display:block;" v-model="loginForm.power" :min="70" :step="5" width="50px" button-style="round"></inline-x-number>
        </cell>
        <!-- <x-input title="精力" v-model="loginForm.spirit" placeholder="给你的状态打个分吧"></x-input>
        <x-input title="体力" v-model="loginForm.power" placeholder="感觉今天体力如何呢"></x-input> -->
        <x-switch title="今天美么" v-model="loginForm.is_beauty"></x-switch>
        <cell title="饮水量">
          <inline-x-number style="display:block;" v-model="loginForm.water" :min="1000" :step="500" width="50px" button-style="round"></inline-x-number>
        </cell>
        <x-input title="食物" v-model="loginForm.food" placeholder="要少吃哦"></x-input>
        <x-switch title="学习" v-model="loginForm.is_study"></x-switch>
        <x-switch title="锻炼" v-model="loginForm.is_exercise"></x-switch>
        <x-input title="锻炼项目" v-model="loginForm.exercise"  placeholder="消耗卡路里的动作都可以记录哦"></x-input>
        <x-switch title="梦" v-model="loginForm.is_dream"></x-switch>
        <x-switch title="痘痘" v-model="loginForm.is_pimple"></x-switch>
        <x-switch title="大姨妈" v-model="loginForm.is_period"></x-switch>
        <cell title="便便次数">
          <inline-x-number style="display:block;" v-model="loginForm.shit_time" :min="0" width="50px" button-style="round"></inline-x-number>
        </cell>
        <!-- <x-input title="便便体验" v-model="loginForm.shit_type" ></x-input> -->
        <x-textarea title="我还有话说" v-model="loginForm.item"></x-textarea>
        <x-button type="primary" class="@button-global-border-radius" v-on:click.native="submitData">提交记录</x-button>
      </group>
    <Foot></Foot>
  </div>
</template>

<script>
import { Range, InlineXSwitch, XSwitch, Loading, Actionsheet, Toast, querystring, Cell, XInput, Calendar, Radio, XButton, InlineXNumber, XTextarea } from 'vux'
import Foot from '@/components/Foot'
import {
  bodyDailyGet,
  bodyDailyAdd
} from '@/api/index'
export default {
  name: 'bodyDaily',
  components: {
    Foot,
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
      msg: '每天改变一点点',
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
        water: this.loginForm.water,
        is_dream: this.loginForm.is_dream,
        is_exercise: this.loginForm.is_exercise,
        is_pimple: this.loginForm.is_pimple,
        is_period: this.loginForm.is_period,
        is_study: this.loginForm.is_study,
        is_beauty: this.loginForm.is_beauty,
        exercise: this.loginForm.exercise,
        item: this.loginForm.item,
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
