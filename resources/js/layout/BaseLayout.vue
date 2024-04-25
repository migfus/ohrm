<script setup lang="ts">
import { useTitle } from '@vueuse/core'

import TopNavigation from '@/components/navigation/TopNavigation.vue'
import SideNavigation from '@/components/navigation/SideNavigation.vue'
import TopBanner from '@/components/navigation/TopBanner.vue'
import BaseFooter from '@/components/footer/BaseFooter.vue'

const $props = defineProps<{
  sidebar: boolean
  system_settings: {
    config: string
  }[]
  title: string
}>()

useTitle($props.title)
</script>

<template>
  <TopBanner />

  <SideNavigation v-if="$props.sidebar">
    <div class="mx-auto max-w-7xl">
      <slot></slot>
    </div>
  </SideNavigation>

  <TopNavigation v-else>
    <div class="mx-auto max-w-7xl">
      <slot></slot>
    </div>
  </TopNavigation>

  <BaseFooter />
</template>
