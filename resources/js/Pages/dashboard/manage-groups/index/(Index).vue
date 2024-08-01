
<template>
  <div>
    <HeaderContent
      v-model="throttledSearch"
      :allowSearch="true"
      title="Manage Groups"
      desc="Create, modify & assign members to groups"
      @add="showCreateGroupModal = true"
    />

    <TabSection v-model="selected" :data="tabs"/>

    <div class="bg-white mt-2">
      <DataTransition v-if="$props.data.data.length > 0" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-2">
        <GroupCard v-for="row in $props.data.data" :data="row" :key="row.id"/>
      </DataTransition>

      <DataTransition v-else>
        <div class="bg-brand-50 p-4 text-brand-600 flex justify-center">
          <p class="mx-auto text-[60px]">
            <span class="animate-pulse">Not Found </span>
            <span class="text-[60px] m-4 animate-pulse delay-200">😅</span>
          </p>
        </div>
      </DataTransition>
    </div>

    <PaginationCard :data @changePage="ChangePage" />

    <!-- NOTE: CREATE MODAL -->
    <Create v-model="showCreateGroupModal" />
  </div>
</template>

<script setup lang="ts">
import { ref, watch, reactive } from 'vue'
import { Filters, Group, Pagination, Tab } from '@/globalTypes'
import { router } from '@inertiajs/vue3'
import { useThrottle } from '@vueuse/core'

import HeaderContent from '@/components/headers/HeaderContent.vue'
import TabSection from '@/components/headers/TabSection.vue'
import PaginationCard from '@/components/data/PaginationCard.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'
import GroupCard from '@/components/data/GroupCard.vue'
import Create from './Create.vue'


const $props = defineProps<{
  filters: Filters,
  data: Pagination<Group>
}>()

const showCreateGroupModal = ref<boolean>(false)
// NOTE: Search
const throttledSearch = ref($props.filters.search ?? '')
const form = reactive({
  search: useThrottle(throttledSearch, 1000),
  page: 1,
})

watch(form, () => {
  Search()
})

function ChangePage(page: number) {
  form.page = page
}
function Search() {
  router.get(route('dashboard.manage-groups.index'), form, { preserveState: true })
}

// NOTE: Tabs
const tabs: Tab[] = [
  {
    display_name: 'All',
    hero_icon: {
      name: 'icon',
      content: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>`
    }
  }
]
const selected = ref(0)
</script>
