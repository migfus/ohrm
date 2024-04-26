<script setup lang="ts">
import { useTitle } from '@vueuse/core'
import { Head } from '@inertiajs/vue3'
import { watch } from 'vue'
import { TProps } from '@/globalTypes'

import TopNavigation from '@/components/navigation/TopNavigation.vue'
import SideNavigation from '@/components/navigation/SideNavigation.vue'
import TopBanner from '@/components/navigation/TopBanner.vue'
import BaseFooter from '@/components/footer/BaseFooter.vue'

const $props = defineProps<TProps>()

const $title = useTitle($props.pageTitle ? `${$props.pageTitle} | ${$props.title}` : $props.title)
watch($props, () => {
  $title.value = `${$props.pageTitle} | ${$props.title}`
})
</script>

<template>
  <Head>
    <title>{{ $title }}</title>
    <link rel="icon" type="image/png" :href="$props.logo.sm" />
  </Head>

  <TopBanner />

  <SideNavigation v-if="$props.sidebar" :title="$props.title" :logo="$props.logo.lg">
    <div class="mx-auto max-w-7xl">
      <slot></slot>
    </div>
  </SideNavigation>

  <TopNavigation v-else :title="$props.title" :logo="$props.logo.sm">
    <div class="mx-auto max-w-7xl">
      <slot></slot>
    </div>
  </TopNavigation>

  <BaseFooter />
</template>
