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

const $page = usePage<SharedProps>()
const title = computed(() => $page.props.title)
const pageTitle = computed(() => $page.props.pageTitle)
const flash = computed(() => {
  if($page.props.flash?.success) {
    alert($page.props.flash?.success)
  }
  else if($page.props.flash?.error) {
    alert($page.props.flash?.error)
  }
  return $page.props.flash;
})

const _title = useTitle(pageTitle.value ? `${pageTitle.value} | ${title.value}` : title.value)
watch(pageTitle, () => {
  _title.value = `${pageTitle.value} | ${title.value}`
})
</script>

<template>
  <Head>
    <link rel="icon" type="image/png" :href="$page.props.logo.sm" />
  </Head>

  <!-- <TopBanner /> -->

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
