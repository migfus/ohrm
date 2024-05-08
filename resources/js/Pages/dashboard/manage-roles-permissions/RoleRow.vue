<template>
  <div class="relative flex items-start pb-4 pt-3.5">
    <div class="min-w-0 flex-1 text-sm leading-6">
      <label for="comments" :class="[row.name == 'admin' ? 'line-through' : '' ,'font-medium text-gray-900']">{{ data.display_name }}</label>
      <p id="comments-description" class="text-gray-500">{{ data.description }}</p>
    </div>
    <div class="ml-3 flex h-6 items-center">
      <input
        v-if="!loading"
        @click="changePermission(row, data.id, $event)"
        :checked="row.permissions.filter(p => p.id === data.id).length > 0 ? true : false"
        :id="data.name"
        :aria-describedby="`${data.name}-description`"
        :name="data.name"
        type="checkbox"
        class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-600 disabled:text-brand-300"
        :disabled="row.name == 'admin'"
      />
      <ArrowPathIcon v-else class="h-5 w-5 text-bran-400 animate-spin" aria-hidden="true" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { TPermission, TRole } from '@/globalTypes'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

import { ArrowPathIcon } from '@heroicons/vue/20/solid'

defineProps<{
  data: TPermission
  row: TRole
}>()

const loading = ref(false)

function changePermission(role: TRole, permission_id: string, event: Event) {
  router.post(
    `/dashboard/manage-roles-permissions`,
    {
      permission_id: permission_id,
      role_id: role.id,
      type: 'permission',
      // @ts-ignore
      value: event.target.checked
    },
    // {preserveState: true}
  )
  loading.value = true
}


router.on('finish',() => {
  loading.value = false
})

</script>
