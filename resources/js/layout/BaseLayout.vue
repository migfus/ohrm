<script setup lang="ts">
import { useTitle } from '@vueuse/core'
import { Head } from '@inertiajs/vue3'
import { watch, ref } from 'vue'
import SharedProps from './SharedProps'
import { usePage } from '@inertiajs/vue3'

import TopNavigation from '@/components/navigation/TopNavigation.vue'
import SideNavigation from '@/components/navigation/SideNavigation.vue'
import TopBanner from '@/components/navigation/TopBanner.vue'
import BaseFooter from '@/components/footer/BaseFooter.vue'

const page = usePage<SharedProps>()

const $title = ref(page.props.pageTitle ? `${page.props.pageTitle} | ${page.props.title}` : page.props.title)
watch(page.props, () => {
  $title.value = `${page.props.pageTitle} | ${page.props.title}`
})
</script>

<template>
  <Head :title="$title">
    <link rel="icon" type="image/png" :href="page.props.logo.sm" />
  </Head>

  <!-- <TopBanner /> -->

  <SideNavigation v-if="page.props.sidebar" :title="page.props.title" :logo="page.props.logo.lg">
    <div class="mx-auto max-w-7xl">
      <slot></slot>
    </div>
  </SideNavigation>

  <TopNavigation v-else :title="page.props.title" :logo="page.props.logo.sm">
    <div class="mx-auto max-w-7xl">
      <slot></slot>
    </div>
  </TopNavigation>

  <BaseFooter />
</template>
