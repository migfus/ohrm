<template>
  <Menu as="div" class="relative inline-block text-left">
    <div>
      <MenuButton class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-brand-50 pl-2 pb-2 text-sm font-semibold text-brand-900 hover:bg-brand-50 ">
        <ChevronDownIcon class="-mr-1 h-5 w-5 text-brand-400" aria-hidden="true" />
      </MenuButton>
    </div>

    <BasicTransition >
      <MenuItems class="absolute right-0 z-10 w-32 origin-top-right rounded-2xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none p-1">
        <div class="">
          <MenuItem v-slot="{ active }">
            <div @click="click('pin')" :class="[active ? 'bg-brand-100 text-brand-600' : 'text-brand-700', 'block pl-3 py-2 text-sm rounded-2xl']">
              <MapPinIcon :class="[active ? 'bg-brand-100 text-brand-600' : 'text-brand-700', 'h-4 w-5 text-brand-400 inline mr-2']"  />
              <span>{{ isPinned ? 'Unpin' : 'Pin'}}</span>
            </div>
          </MenuItem>
          <MenuItem v-slot="{ active }">
            <div @click="click('edit')" :class="[active ? 'bg-brand-100 text-brand-600' : 'text-brand-700', 'block pl-3 py-2 text-sm rounded-2xl']">
              <PencilIcon :class="[active ? 'bg-brand-100 text-brand-600' : 'text-brand-700', 'h-4 w-5 text-brand-400 inline mr-2']"  />
              <span>Edit</span>
            </div>
          </MenuItem>
          <MenuItem v-slot="{ active }">
            <div @click="click('report')" :class="[active ? 'bg-red-100 text-red-900' : 'text-brand-700', 'block pl-3 py-2 text-sm rounded-2xl']">
              <FlagIcon :class="[active ? 'bg-red-100 text-red-900' : 'text-brand-700', 'h-4 w-5 text-brand-400 inline mr-2']"  />
              <span>Report</span>
            </div>
          </MenuItem>
          <MenuItem v-slot="{ active }">
            <div @click="click('delete')" :class="[active ? 'bg-red-100 text-red-900' : 'text-brand-700', 'block pl-3 py-2 text-sm rounded-2xl']">
              <XMarkIcon :class="[active ? 'bg-red-100 text-red-900' : 'text-brand-700', 'h-5 w-5 text-brand-400 inline mr-2']"  />
              <span>Delete</span>
            </div>
          </MenuItem>
        </div>
      </MenuItems>
    </BasicTransition>
    <RemovalPrompt v-model="open_remove_prompt" title="Remove Selected Post?" confirmMessage="Remove this Post" @confirm="confirmRemove()">
      Do you want to remove this post?
    </RemovalPrompt>
  </Menu>
</template>

<script setup lang="ts">
import { ref } from 'vue'

import { Menu, MenuButton, MenuItem, MenuItems,  } from '@headlessui/vue'
import { ChevronDownIcon, XMarkIcon, FlagIcon, PencilIcon, MapPinIcon } from '@heroicons/vue/20/solid'
import BasicTransition from '@/components/transitions/BasicTransition.vue'
import RemovalPrompt from '@/components/modals/RemovalPrompt.vue'

defineProps<{
  isPinned: number // 0 or 1
}>()

const $emits = defineEmits(['click'])
const open_remove_prompt = ref(false)

function click(value: string) {
  if(value == 'delete') {
    open_remove_prompt.value = true
  }
  else {
    $emits('click', value)
  }
}

function confirmRemove() {
  $emits('click', 'delete')
}
</script>
