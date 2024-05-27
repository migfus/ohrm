<template>
  <div class="flex mt-4 bg-brand-50 rounded-xl shadow p-4 justify-end">
    <TailwindPagination
      :data
      @pagination-change-page="changePage"
      :active-classes="['bg-brand-400', 'text-white', 'border-brand-500']"
      :item-classes="['border-brand-300', 'text-brand-600']"
    />
  </div>
</template>

<script setup lang="ts">
// @ts-ignore NOTE: not my issue 😅
import { TailwindPagination } from 'laravel-vue-pagination'

defineProps<{
  data: Object
}>()
const $emit = defineEmits(['changePage'])

function changePage(page: number) {
  $emit('changePage', page)
}
</script>
