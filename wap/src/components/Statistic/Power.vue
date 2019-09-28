<template>
  <div class="a-lists">
    <div class="box"  style="background:#fff">
        <checker v-model="month" @on-change="selectByMonth" default-item-class="demo2-item" selected-item-class="demo2-item-selected">
          <span v-for="(item, i) in months" :key="i">
            <checker-item :value="item"><span v-if="item == month" style='color:#67C23A;'>{{ item }}</span><span v-else>{{ item }}</span></checker-item>
          </span>
        </checker>
    </div>
    <divider>{{ month }}月状态数据分析</divider>
    <v-chart :data="data">
      <v-line series-field="type" />
    </v-chart>

    <divider>{{ month }}月运动数据</divider>
    <v-chart
        :data="statisticData"
        :padding="[20, 'auto']">
        <v-tooltip disabled />
        <v-scale y :options="yOptions" />
        <v-pie :radius="0.85" :inner-radius="0.7" series-field="name" :colors="['#3BA4FF','#737DDE']" />
        <v-legend :options="legendOptions" />
        <v-guide type="html" :options="htmlOptions" />
      </v-chart>
    <Foot></Foot>
  </div>
</template>

<script>
import { Checker, CheckerItem, dateFormat, VChart, VLine, VAxis, VTooltip, VArea, VLegend, VBar, VPie, VGuide, VScale, Divider } from 'vux'

import Foot from '@/components/Foot'
import {
  powerStatistic
} from '@/api/index'

export default {
  name: 'statisticPower',
  components: {
    Checker,
    CheckerItem,
    dateFormat,
    VChart,
    VLine,
    VAxis,
    VTooltip,
    VArea,
    VLegend,
    VBar,
    VPie,
    VGuide,
    VScale,
    Divider,
    Foot
  },
  data () {
    var statisticData = [
      { name: '锻炼', percent: 0 },
      { name: '未锻炼', percent: 0 }
    ]

    var map = {}
    statisticData.map(obj => {
      map[obj.name] = obj.percent + '天'
    })
    var myDate = new Date()
    var month = String(myDate.getMonth() + 1)
    // var now = dateFormat(new Date(), 'YYYY-MM-DD')
    var months = Array(7)
    var allMonths = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
    if (month < 6) {
      months = allMonths.slice(0, month)
    } else {
      months = allMonths.slice(month - 6, month)
    }
    return {
      statisticData,
      map,
      month,
      months,
      htmlOptions: {
        position: [ '50%', '45%' ],
        html: `
          <div style="width: 250px;height: 40px;text-align: center;">
            <div style="font-size: 16px">锻炼数据</div>
            <div style="font-size: 24px">30天</div>
          </div>`
      },
      legendOptions: {
        position: 'right',
        itemFormatter (val) {
          return val + '  ' + map[val]
        }
      },
      yOptions: {
        formatter (val) {
          return val * 100 + '%'
        }
      },
      data: [
        { date: 'Feb.', type: 'power', value: 28.8 },
        { date: 'Feb.', type: 'period', value: 0 },
        { date: 'Aug.', type: 'weight', value: 42.4 }
      ]
    }
  },
  created () {
    powerStatistic(dateFormat(new Date(), 'YYYY-MM')).then((response) => {
      this.data = response.data.data.data
      this.statisticData = response.data.data.statisticData
      this.statisticData.map(obj => {
        this.map[obj.name] = obj.percent + '天'
      })
    }).catch((error) => {
      console.log(error)
    })
  },
  methods: {
    selectByMonth () {
      var selectMonth = dateFormat(new Date(), 'YYYY') + '-' + this.month
      powerStatistic(selectMonth).then((response) => {
        this.data = response.data.data.data
        this.statisticData = response.data.data.statisticData
        this.statisticData.map(obj => {
          this.map[obj.name] = obj.percent + '天'
        })
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
