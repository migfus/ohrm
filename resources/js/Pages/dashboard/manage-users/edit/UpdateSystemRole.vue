<template>
  <BasicCard :icon="AdjustmentsHorizontalIcon" title="Update System Role" description="User's system role.">
    <AppToggleSelect
      name="Role"
      :defaultValue="userRole"
      v-model="form.role"
      :suggestions="roles.map(role => {
        return {
          display_name: role.display_name,
          id: role.id
        }
      })"
      @submit="submit()"
    />
  </BasicCard>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { TRole } from '@/globalTypes'

import { AdjustmentsHorizontalIcon } from '@heroicons/vue/24/solid'
import BasicCard from '@/components/cards/BasicCard.vue'
import AppToggleSelect from '@/components/form/AppToggleSelect.vue'

const $props = defineProps<{
  roles: TRole []
  userRole: TRole
  userId: string
}>()

const form = router.form({
  role: $props.userRole
})

function submit() {
  router.put(`/dashboard/manage-users/${$props.userId}`, {
    userRoleId: form.role.id,
    type: 'update-role'
  }, {
    preserveScroll: true,
    preserveState: true,
  })
}

</script>
