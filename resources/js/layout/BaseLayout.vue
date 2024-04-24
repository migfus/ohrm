<script setup lang="ts">
import { notify } from 'notiwind'
import { computed } from 'vue'

import TopNavigation from '@/components/navigation/TopNavigation.vue'
import SideNavigation from '@/components/navigation/SideNavigation.vue'
import TopBanner from '@/components/navigation/TopBanner.vue'
import BaseFooter from '@/components/footer/BaseFooter.vue'
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const sidebar = computed(() => page.props.sidebar as boolean)
</script>

<template>
  <TopBanner />

  <SideNavigation v-if="sidebar">
    <div class="mx-auto max-w-7xl"></div>
    <slot></slot>
  </SideNavigation>

  <TopNavigation v-else>
    <div class="mx-auto max-w-7xl">
      <slot></slot>
    </div>
  </TopNavigation>

  <BaseFooter />

</template>
