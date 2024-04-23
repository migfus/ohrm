<script setup lang="ts">
import { notify } from 'notiwind'

import TopNavigation from '@/components/topnavigation/TopNavigation.vue'
import TopBanner from '@/components/topnavigation/TopBanner.vue'
import BaseFooter from '@/components/footer/BaseFooter.vue'

// if($page.props.flash.message) {
//   notify({
//     group: "foo",
//     title: "Success",
//     text: "Your account was registered!"
//   }, 4000)
// }

</script>


<template>

  <TopBanner />
  <TopNavigation />
  <slot></slot>

  <BaseFooter />
</template>
