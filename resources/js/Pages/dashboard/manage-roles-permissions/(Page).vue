<template>
  <div>
    <AlertSection title="Attention needed" storage-key="roles-permission">
      <p>You cannot modify "Administrator" role to prevent accidental removing permission, it may result unexpected behavior of the website</p>
    </AlertSection>
    <HeaderContent title="Manage Roles & Permissions" desc="Assign Premissions to Roles and Users"/>
    <TabContent v-model="selected" :data="tabs"/>

    <!-- NOTE: ROLES -->
    <RolesContent v-if="selected == 0" :roles :permissions/>

    <!-- NOTE: TEAMS -->
    <TeamsContent v-else :teams/>
  </div>
</template>

<script setup lang="ts">
import { TPermission, TRole, TTab, TTeam } from '@/globalTypes'
import { ref } from 'vue'

import HeaderContent from '@/components/header/HeaderContent.vue'
import TabContent from '@/components/header/TabContent.vue'
import { EnvelopeIcon, PhoneIcon } from '@heroicons/vue/20/solid'
import { FolderIcon, ShieldCheckIcon } from '@heroicons/vue/24/outline';
import DataTransition from '@/components/transitions/DataTransition.vue';
import RolesContent from './RolesContent.vue'
import TeamsContent from './TeamsContent.vue'
import AlertSection from '@/components/header/AlertSection.vue'

const $props = defineProps<{
  roles: TRole[]
  permissions: TPermission[]
  teams: TTeam[]
}>()

const selected = ref(0) // default 0 index
const tabs: TTab[] = [
  {
    name: 'Roles',
    icon: ShieldCheckIcon,
  },
  {
    name: 'Teams',
    icon: FolderIcon,
  }
]

</script>



