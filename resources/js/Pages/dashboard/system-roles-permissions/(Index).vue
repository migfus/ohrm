<template>
  <div>
    <AlertSection title="Attention needed" storage-key="roles-permission">
      <p>You cannot modify "Administrator" role to prevent accidental removing permission, it may result unexpected behavior of the website</p>
    </AlertSection>

    <HeaderContent
      v-model="form.search"
      :allowSearch="true"
      title="Manage Roles & Permissions"
      desc="Assign Premissions to Roles and Users"
    />

    <TabSection v-model="selected" :data="tabs" :disableLoading="true"/>

    <!-- NOTE: ROLES -->
    <RolesContent v-if="selected == 0" :roles :permissions :errors/>
  </div>
</template>

<script setup lang="ts">
import { Permission, Role, Tab } from '@/globalTypes'
import { ref, reactive } from 'vue'

import HeaderContent from '@/components/header/HeaderContent.vue'
import TabSection from '@/components/header/TabSection.vue'
import RolesContent from './RolesContent.vue'
import AlertSection from '@/components/header/AlertSection.vue'

defineProps<{
  roles: Role[]
  permissions: Permission[]
  errors: object
}>()

const form = reactive({
  search: ''
})

const selected = ref(0) // default 0 index
const tabs: Tab[] = [
  {
    display_name: 'Roles',
    hero_icon: {
      name: 'idk',
      content:  `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                </svg>`
    }
  },
]
</script>



