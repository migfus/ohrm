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

    <TabContent v-model="selected" :data="tabs"/>

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
import TabContent from '@/components/header/TabContent.vue'
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
    icon: ShieldCheckIcon,
  },
  {
    display_name: 'Teams',
    icon: FolderIcon,
  }
]
</script>



