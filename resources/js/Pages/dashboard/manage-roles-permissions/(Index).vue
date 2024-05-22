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

    <!-- NOTE: TEAMS -->
    <TeamsContent v-else :teams/>
  </div>
</template>

<script setup lang="ts">
import { TPermission, TRole, TTab, TTeam } from '@/globalTypes'
import { ref, reactive } from 'vue'

import { FolderIcon, ShieldCheckIcon } from '@heroicons/vue/24/outline'
import HeaderContent from '@/components/header/HeaderContent.vue'
import TabSection from '@/components/header/TabSection.vue'
import RolesContent from './RolesContent.vue'
import TeamsContent from './TeamsContent.vue'
import AlertSection from '@/components/header/AlertSection.vue'

defineProps<{
  roles: TRole[]
  permissions: TPermission[]
  teams: TTeam[]
  errors: object
}>()

const form = reactive({
  search: ''
})

const selected = ref(0) // default 0 index
const tabs: TTab[] = [
  {
    display_name: 'Roles',
    icon: `
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
      </svg>`
  },
  {
    display_name: 'Teams',
    icon: `
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
      </svg>`,
  }
]
</script>



