<template>
  <div class="hello">
    <group title="您近期数据概览" class="form">
      <cell v-for="(item, i) in logs" :key="i" :title="item.date" is-link  :link="{ path: 'bodyDaily?date='+item.date }" >
        <div class="badge-value">
          <span class="vertical-middle"><span style='color:#67C23A;' v-if="item.is_exercise">运动</span><span style='color:#909399' v-else>废柴</span>,
          <span style='color:#E6A23C;' v-if="item.weight >= 97">{{ item.weight}}斤</span><span v-else>{{ item.weight}}斤</span>,
          <span style='color:#F56C6C;' v-if="item.spirit <= 65">精力:{{ item.spirit }}</span><span v-else>精力:{{ item.spirit }}</span>
          </span>
        </div>
      </cell>
    </group>
    <el-button class='addButton' type="primary" circle @click="linkTo(today)">记</el-button>
    <Foot></Foot>
  </div>
</template>

<script>
import Foot from '@/components/Foot'
import { Badge, Group, Cell } from 'vux'
import {
  bodyDailyList
} from '@/api/index'
export default {
  name: 'bodyDaily',
  components: {
    Foot,
    Badge,
    Group,
    Cell
  },
  data () {
    return {
      msg: '你的数据',
      today: '',
      logs: {}
    }
  },
  created () {
    bodyDailyList().then((response) => {
      this.logs = response.data.data
    }).catch((error) => {
      console.log(error)
    })
  },
  methods: {
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
</style>
