<template>
  <div>
    <label for="">Own Tasks</label>
    <DataTable :data="tasks" />
  </div>
</template>

<script setup lang="ts">
import { Task } from '@/globalTypes'

import DataTable from '@/components/test/DataTable.vue'

defineProps<{
  tasks: Task[]
}>()
</script>
