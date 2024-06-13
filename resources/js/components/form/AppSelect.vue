<template>
  <select
    :id="name"
    :name="name"
    :autocomplete="name"
    v-model="$model"
    class="block w-full rounded-2xl border-0 bg-white py-1.5 text-brand-700 sm:text-sm font-medium shadow"
  >
    <option
      v-for="item in suggestions"
      :value="item"
      class="font-medium"
      :selected="item.display_name == $model!.display_name"
    >
      {{ item.display_name }}
    </option>
  </select>
</template>

<script setup lang="ts">
import { TSelect } from '@/globalTypes';

defineProps<{
  suggestions: TSelect []
  name: string
}>()

const $model = defineModel<TSelect>()
</script>
