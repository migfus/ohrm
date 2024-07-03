<script setup lang="ts">
import { useTitle } from '@vueuse/core'
import { Head } from '@inertiajs/vue3'
import { watch, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import TopNavigation from '@/components/navigation/TopNavigation.vue'
import SideNavigation from '@/components/navigation/SideNavigation.vue'
import TopBanner from '@/components/navigation/TopBanner.vue'
import BaseFooter from '@/components/footer/BaseFooter.vue'
import SharedProps from '@/SharedProps'
import NotiWind from '@/components/notifications/NotiWind.vue'
import { notify } from "notiwind"

const $page = usePage<SharedProps>()
const title = computed(() => $page.props.title)
const pageTitle = computed(() => $page.props.pageTitle)
const flash = computed<{
    success?: string
    error?: string
  }>(() => {
    return {
      success: $page.props.flash?.success,
      error: $page.props.flash?.error,
    };
  })

const _title = useTitle(pageTitle.value ? `${pageTitle.value} | ${title.value}` : title.value)
watch(pageTitle, () => {
  _title.value = `${pageTitle.value} | ${title.value}`
})
watch(flash, () => {
  if(flash.value.success){
    notify({
      group: "success",
      title: "Success",
      text: flash.value.success
    }, 4000)
  }
  else if(flash.value.error){
    notify({
      group: "danger",
      title: "Error",
      text: flash.value.error
    }, 5 * 1000)
  }
})
</script>

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
