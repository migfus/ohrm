<script setup lang="ts">
import TopNavigation from '@/components/topnavigation/TopNavigation.vue'
import TopBanner from '@/components/topnavigation/TopBanner.vue'
import BaseFooter from '@/components/footer/BaseFooter.vue'
</script>


<template>
  <TopBanner />
  <TopNavigation />
  <slot></slot>

  <BaseFooter />
</template>
