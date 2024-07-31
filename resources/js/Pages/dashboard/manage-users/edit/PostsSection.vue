<template>
  <div>
    <BasicCard title="Posts" :icon="PencilIcon">
      Posts Here
    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import BasicCard from '@/components/cards/BasicCard.vue'

import { PencilIcon } from '@heroicons/vue/24/solid'
</script>
