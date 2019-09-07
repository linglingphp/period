<template>
    <tabbar>
      <tabbar-item show-dot is-link :link="{ path: '/activity/bodyDailys' }">
        <span class="el-icon-s-home" slot="label"></span>
      </tabbar-item>
      <tabbar-item show-dot is-link :link="{ path: '/member' }">
        <span class="el-icon-s-custom" slot="label"></span>
      </tabbar-item>
    </tabbar>
</template>

<script>
import { XSwitch, XButton } from 'vux'
export default {
  name: 'foot',
  components: {
    XSwitch,
    XButton
  },
  methods: {
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
.weui-tabbar {
  position: fixed !important;
}
</style>
