<template>
  <div>
    <BasicCard title="Posts" :icon="PencilIcon">
      Posts Here
    </BasicCard>
  </div>
</template>

<script setup lang="ts">
import { errorAlert } from '@/converter'
import { onErrorCaptured } from 'vue'

import BasicCard from '@/components/cards/BasicCard.vue'
import { PencilIcon } from '@heroicons/vue/24/solid'

onErrorCaptured((e) => errorAlert('/dashboard/manage-users/edit/PostsSection', e))
</script>
