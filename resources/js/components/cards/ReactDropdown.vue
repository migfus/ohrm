<template>
  <Menu as="div" class="relative inline-block text-left">
    <div>
      <MenuButton class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-brand-50 pl-2 pb-2 text-sm font-semibold text-brand-900 hover:bg-brand-50 ">
        <FaceSmileIcon class="-mr-1 h-5 w-5 text-brand-400" aria-hidden="true" />
      </MenuButton>
    </div>

    <BasicTransition >
      <MenuItems class="absolute left-0 z-10 origin-top-left rounded-2xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none p-1">
        <div class="flex text-2xl cursor-pointer mx-2">
          <MenuItem v-slot="{ active }">
            <div :class="[active ? '-mt-1 drop-shadow-lg' : '', 'block px-1 py-2 rounded-full transition-all']">
              😎
            </div>
          </MenuItem>
          <MenuItem v-slot="{ active }">
            <div :class="[active ? '-mt-1 drop-shadow-lg' : '', 'block px-1 py-2 rounded-2xl transition-all']">
              😎
            </div>
          </MenuItem>
          <MenuItem v-slot="{ active }">
            <div :class="[active ? '-mt-1 drop-shadow-lg' : '', 'block px-1 py-2 rounded-2xl transition-all']">
              😎
            </div>
          </MenuItem>
          <MenuItem v-slot="{ active }">
            <div :class="[active ? '-mt-1 drop-shadow-lg' : '', 'block px-1 py-2 rounded-2xl transition-all']">
              😎
            </div>
          </MenuItem>
        </div>
      </MenuItems>
    </BasicTransition>

  </Menu>
</template>

<script setup lang="ts">

import { Menu, MenuButton, MenuItem, MenuItems,  } from '@headlessui/vue'
import { FaceSmileIcon } from '@heroicons/vue/24/outline'
import BasicTransition from '@/components/transitions/BasicTransition.vue'

const $emits = defineEmits(['click'])

</script>
