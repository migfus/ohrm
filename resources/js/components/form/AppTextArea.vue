<template>
  <div class="col-span-full">
    <label :for="name" class="block text-sm font-medium leading-6 text-brand-700">{{ name }}</label>
    <div class="mt-2">
      <textarea
        v-model="$model"
        :id="name"
        :name="name"
        rows="3"
        class="shadow-inner block w-full rounded-xl border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
const $model = defineModel<string>()
defineProps<{
  name: string
}>()
</script>
