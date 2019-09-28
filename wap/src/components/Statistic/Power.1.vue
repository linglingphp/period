<template>
  <div>
    <v-chart
      ref="demo"
      :data="data">
      <v-scale x field="日期" />
      <v-scale y field="值" />
      <v-bar series-field="name" :adjust="{
        type: 'dodge',
        marginRatio: 0.05 // 设置分组间柱子的间距
      }" />
      <v-tooltip show-value-in-legend />
    </v-chart>

    <x-button type="primary" plain @click.native="$refs.demo.rerender()">rerender</x-button>
 
  <!-- <Foot></Foot> -->
  </div>
</template>

<script>
import { dateFormat, VChart, VLine, VArea, VTooltip, VLegend, VBar, XButton, VScale } from 'vux'
// import Foot from '@/components/Foot'
import {
  powerStatistic
} from '@/api/index'

export default {
  name: 'statisticPower',
  components: {
    dateFormat,
    VChart,
    VLine,
    VArea,
    VTooltip,
    VLegend,
    VBar,
    XButton,
    VScale
  },
  data () {
    // var myDate = new Date()
    // var month = String(myDate.getMonth() + 1)
    // var now = dateFormat(new Date(), 'YYYY-MM-DD')
    return {
      data: [
        { name: 'London', 日期: 'Jan.', 值: 18.9 },
        { name: 'London', 日期: 'Feb.', 值: 28.8 },
        { name: 'London', 日期: 'Mar.', 值: 39.3 },
        { name: 'London', 日期: 'Apr.', 值: 81.4 },
        { name: 'London', 日期: 'May.', 值: 47 },
        { name: 'London', 日期: 'Jun.', 值: 20.3 },
        { name: 'London', 日期: 'Jul.', 值: 24 },
        { name: 'London', 日期: 'Aug.', 值: 35.6 },
        { name: 'Berlin', 日期: 'Jan.', 值: 12.4 },
        { name: 'Berlin', 日期: 'Feb.', 值: 23.2 },
        { name: 'Berlin', 日期: 'Mar.', 值: 34.5 },
        { name: 'Berlin', 日期: 'Apr.', 值: 99.7 },
        { name: 'Berlin', 日期: 'May.', 值: 52.6 },
        { name: 'Berlin', 日期: 'Jun.', 值: 35.5 },
        { name: 'Berlin', 日期: 'Jul.', 值: 37.4 },
        { name: 'Berlin', 日期: 'Aug.', 值: 42.4 }
      ]
    }
  },
  created () {
    const date = this.$route.query['date']
    powerStatistic(date).then((response) => {
      this.data = response.data.data
    }).catch((error) => {
      console.log(error)
    })
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
