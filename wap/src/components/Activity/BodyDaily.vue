<template>
  <div class="hello">
    <group :title="msg">
      <div class="box">
        <checker v-model="month" @on-change="selectByMonth" default-item-class="demo2-item" selected-item-class="demo2-item-selected">
          <span v-for="(item, i) in months" :key="i">
            <checker-item :value="item"><span v-if="item == month" style='color:#67C23A;'>{{ item }}</span><span v-else>{{ item }}</span></checker-item>
          </span>
        </checker>
      </div>
      <divider>现在是{{ month }}月数据哦</divider>
      <div class="a-lists">
        <cell v-for="(item, i) in logs" :key="i" :title="item.date" is-link  :link="{ path: 'bodyDaily?date='+item.date }" >
          <div class="badge-value">
            <span class="vertical-middle"><span style='color:#67C23A;' v-if="item.is_exercise">运动</span><span style='color:#909399' v-else>废柴</span>,
            <span style='color:#E6A23C;' v-if="item.weight >= 97">{{ item.weight}}斤</span><span v-else>{{ item.weight}}斤</span>,
            <span style='color:#F56C6C;' v-if="item.spirit <= 65">精力:{{ item.spirit }}</span><span v-else>精力:{{ item.spirit }}</span>
            </span>
          </div>
        </cell>
      </div>
    </group>
    <el-button class='addButton' type="primary" circle @click="linkTo(today)">记</el-button>
    <Foot></Foot>
  </div>
</template>

<script>
import Foot from '@/components/Foot'
import { Checker, CheckerItem, Divider, dateFormat, Badge, Group, Cell } from 'vux'
import {
  bodyDailyList
} from '@/api/index'
export default {
  name: 'bodyDaily',
  components: {
    Checker,
    CheckerItem,
    Divider,
    dateFormat,
    Foot,
    Badge,
    Group,
    Cell
  },
  data () {
    var myDate = new Date()
    var month = String(myDate.getMonth() + 1)
    var now = dateFormat(new Date(), 'YYYY-MM-DD')
    var months = Array(7)
    var allMonths = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
    if (month < 6) {
      months = allMonths.slice(0, month)
    } else {
      months = allMonths.slice(month - 6, month)
    }
    return {
      msg: '当前日期：' + now,
      today: '',
      logs: {},
      now: now,
      month: month,
      months: months
    }
  },
  created () {
    bodyDailyList(dateFormat(new Date(), 'YYYY-MM')).then((response) => {
      this.logs = response.data.data
    }).catch((error) => {
      console.log(error)
    })
  },
  methods: {
    selectByMonth () {
      var selectMonth = dateFormat(new Date(), 'YYYY') + '-' + this.month
      bodyDailyList(selectMonth).then((response) => {
        this.logs = response.data.data
      }).catch((error) => {
        console.log(error)
      })
    },
    linkTo (date) {
      window.location = '#/activity/bodyDaily?date=' + date
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
.addButton{
  position: absolute;
    display: flex;
    bottom: 10%;
    right: 0;
}
.weui-tabbar {
  position: fixed !important;
}
.form {
    margin-bottom: 100px;
}
.box {
  padding: 0 20px;
  margin-top: 5px;
}
.a-lists {
    margin-bottom: 50px;
}
.demo2-item {
  width: 40px;
  height: 40px;
  margin: 2%;
  border: 1px solid #ccc;
  display: inline-block;
  border-radius: 50%;
  line-height: 40px;
  text-align: center;
}
.demo2-item-selected {
  border-color: green;
}
</style>
