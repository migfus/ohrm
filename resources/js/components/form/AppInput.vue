<script setup lang="ts">
type TProps = {
  error: string | null
  name: string
  type?: 'text' | 'email' | 'password'
  placeholder?: string
}

const $props = defineProps<TProps>()
const $model = defineModel()

</script>

<template>
 <div>
  <label for="password" class="block text-sm font-medium text-gray-700">{{ name }}</label>
  <div class="mt-1">
    <input
      v-model="$model"
      :id="name"
      :name
      :type="type ?? 'text'"
      :placeholder="placeholder ?? ''"
      :class="[
        error && 'border-red-500',
        'block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-brand-500 focus:outline-none focus:ring-brand-500 sm:text-sm'
      ]"
    />
    <label v-if="$props.error" for="password" class="block text-sm font-medium text-red-600">
      {{ $props.error }}
    </label>
  </div>
</div>
</template>

