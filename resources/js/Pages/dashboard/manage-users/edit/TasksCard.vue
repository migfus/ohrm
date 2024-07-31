<template>
  <div>
    <BasicCard :icon="TicketIcon" title="Marked Tasks">
      Marked Tasks here
    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'

import { TicketIcon } from '@heroicons/vue/24/solid'
</script>
