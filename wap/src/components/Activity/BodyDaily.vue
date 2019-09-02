<template>
  <div class="hello">
    <p>{{ msg }}</p>
    <group title="您近期数据概览">
      <cell v-for="(item, i) in logs" :key="i" :title="item.date" is-link  :link="{ path: 'bodyDaily?date='+item.date }" >
        <div class="badge-value">
          <span class="vertical-middle">{{ item.weight}}斤-power:{{ item.spirit }}</span>
        </div>
      </cell>
    </group>
    <tabbar>
      <tabbar-item show-dot is-link :link="{ path: 'bodyDailys' }">
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
import { Badge, Group, Cell } from 'vux'
import {
  bodyDailyList
} from '@/api/index'
export default {
  name: 'bodyDaily',
  components: {
    Badge,
    Group,
    Cell
  },
  data () {
    return {
      msg: '你的数据',
      logs: {}
    }
  },
  created () {
    console.log('1111')
    bodyDailyList().then((response) => {
      this.logs = response.data.data
      console.log(this.logs)
    }).catch((error) => {
      console.log(error)
    })
  },
  methods: {
    linkTo (date) {
      console.log('1111')
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
</style>
