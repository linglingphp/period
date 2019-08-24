<template>
  <div class="hello">
    <p>{{ msg }}</p>
    <div>
      <group>
        <calendar title="日期" v-model="loginForm.date"></calendar>
        <x-input title="体重" v-model="loginForm.weight" text-align="right"></x-input>
        <x-input title="精力值" v-model="loginForm.spirit" text-align="right"></x-input>
        <x-input title="体力值" v-model="loginForm.power" text-align="right" ></x-input>
        
        <x-input title="梦" v-model="loginForm.dream_type" text-align="right" ></x-input>
        <cell title="饮水量">
          <inline-x-number style="display:block;" v-model="loginForm.water" :min="1000" :step="100" width="50px" button-style="round"></inline-x-number>
        </cell>
        <x-textarea title="锻炼" v-model="loginForm.exercise"></x-textarea>
        <x-textarea title="食物" v-model="loginForm.food"></x-textarea>
        <cell title="便便次数">
          <inline-x-number style="display:block;" v-model="loginForm.shit_time" :min="0" width="50px" button-style="round"></inline-x-number>
        </cell>
        <x-input title="便便体验" v-model="loginForm.shit_type" text-align="right" ></x-input>
      </group>
      <x-button type="primary" class="@button-global-border-radius" v-on:click.native="submitData">提交记录</x-button>
    </div>
  </div>
</template>

<script>
import { Cell, XInput, Calendar, Radio, XButton, InlineXNumber, XTextarea } from 'vux'
import {
  bodyDailyGet,
  bodyDailyAdd
} from '@/api/index'
export default {
  name: 'bodyDaily',
  components: {
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
      msg: '记录你今天的数据吧',
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
    console.log('1111')
    bodyDailyGet().then((response) => {
      this.loginForm = response.data.data
      console.log(this.loginForm)
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
        exercise: this.loginForm.exercise,
        food: this.loginForm.food
      }).then((response) => {
        // this.linkTo()
      }).catch((error) => {
        console.log(error)
      })
    },
    linkTo () {
      window.location = '#/activity'
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
