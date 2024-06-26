<template>
  <BasicCard :icon="MegaphoneIcon" title="Pinned Posts" description="Pinned Post (as announcement)">
    Pinned Post
  </BasicCard>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'
import { MegaphoneIcon } from '@heroicons/vue/20/solid'
</script>
