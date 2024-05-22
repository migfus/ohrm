
<template>
  <div>
    <HeaderContent
      v-model="throttledSearch"
      :allowSearch="true"
      title="Manage Users"
      desc="Create, modify, or generate report users informations"
      @add="router.visit('/dashboard/manage-groups/create')"
    />

    <TabContent v-model="selected" :data="tabs"/>

    <div class="overflow-hidden bg-white shadow sm:rounded-xl mt-2">
      <DataTransition v-if="$props.data.data.length > 0" role="list" class="divide-y divide-gray-200">
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

  </div>
</template>

<script setup lang="ts">
import { ref, watch, reactive } from 'vue'
import { TFilters, TTeam } from '@/globalTypes'
import { router } from '@inertiajs/vue3'
import { useThrottle } from '@vueuse/core'

import HeaderContent from '@/components/header/HeaderContent.vue'
import TabContent from '@/components/header/TabContent.vue'
import { SquaresPlusIcon } from '@heroicons/vue/24/outline'
import PaginationCard from '@/components/data/PaginationCard.vue'
import DataTransition from '@/components/transitions/DataTransition.vue'
import GroupCard from '@/components/data/GroupCard.vue'

const $props = defineProps<{
  filters: TFilters,
  tabs: {
    name: string
  } []
  data: {
    data: TTeam []
  }
}>()

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
  router.get('/dashboard/manage-groups', form, { preserveState: true })
}

// NOTE: Tabs
const tabs = [
  {
    display_name: 'All',
    icon: SquaresPlusIcon
  }
]
const selected = ref(0)
</script>
