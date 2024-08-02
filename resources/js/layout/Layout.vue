<template>
  <Head>
    <link rel="icon" type="image/png" :href="$page.props.logo.sm" />
  </Head>

  <!-- <TopBanner /> -->

  <NotiWind />

  <SideNavigation v-if="$page.props.sidebar" :title="$page.props.title" :logo="$page.props.logo.lg">
    <div class="mx-auto max-w-7xl">
      <slot></slot>
    </div>
  </SideNavigation>

  <TopNavigation v-else :title="$page.props.title" :logo="$page.props.logo.sm">
    <div class="mx-auto max-w-7xl">
      <slot></slot>
    </div>
  </TopNavigation>

  <BaseFooter />
</template>

<script setup lang="ts">
import { useTitle } from '@vueuse/core'
import { Head } from '@inertiajs/vue3'
import { watch, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

import TopNavigation from '@/components/navigations/TopNavigation.vue'
import SideNavigation from '@/components/navigations/SideNavigation.vue'
import BaseFooter from '@/components/footers/BaseFooter.vue'
import SharedProps from '@/SharedProps'
import NotiWind from '@/components/notifications/NotiWind.vue'
import { notify } from "notiwind"

const $page = usePage<SharedProps>()

// NOTE: HEADER TITLE (Constantly change in every navigation)
const title = computed(() => $page.props.title)
const page_title = computed(() => $page.props.page_title)
const _title = useTitle(page_title.value ? `${page_title.value} | ${title.value}` : title.value)
watch(page_title, () => {
  _title.value = `${page_title.value} | ${title.value}`
})

// NOTE: NOTIWIND BASE NOTIFICATIONS (Actively listening to flash messages)
const flash = computed<{
  success?: {
    title: string
    content: string
  }
  error?: {
    title: string
    content: string
  }
}>(() => {
  return {
    success: $page.props.flash?.success,
    error: $page.props.flash?.error,
  };
})

watch(flash, () => {
  if(flash.value.success){
    notify({
      group: "success",
      title: flash.value.success.title,
      content: flash.value.success.content
    }, 4000)
  }
  else if(flash.value.error){
    notify({
      group: "error",
      title: flash.value.error.title,
      content: flash.value.error.content
    }, 5 * 1000)
  }
})
</script>
