<template>
  <Menu as="div" class="relative inline-block text-left">
    <div>
      <MenuButton class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-brand-50 pl-2 text-sm font-semibold text-brand-900 hover:bg-brand-50 ">
        <DataTransition v-if="reaction_users.length > 0" class="flex">
          <div v-for="reaction in sorted_reactions" :key="reaction.id" class="mr-2 cursor-pointer">
            <!-- NOTE: COUNT -->
            <label>
              {{ reaction.total }}
            </label>
            <!-- NOTE: REACTION EMOJI -->
            <label class="text-lg inline cursor-pointer">
              {{ reaction.reaction.content }}
            </label>
          </div>
        </DataTransition>

        <FaceSmileIcon v-else class="-mr-1 h-6 w-6 text-brand-400" aria-hidden="true" />

      </MenuButton>
    </div>

    <BasicTransition>
      <MenuItems class="absolute left-0 z-10 origin-top-left rounded-2xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none p-1">
        <DataTransition class="flex text-2xl mx-2">
          <MenuItem v-for="react in reactions" v-slot="{ active }">
            <div @click="doReact(postId, react.id)" :class="[active ? '-mt-1 drop-shadow-lg' : '', 'block px-1 py-2 rounded-full transition-all cursor-pointer']">
              {{ react.content }}
            </div>
          </MenuItem>
        </DataTransition>
      </MenuItems>
    </BasicTransition>
  </Menu>
</template>

<script setup lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { FaceSmileIcon } from '@heroicons/vue/24/outline'
import BasicTransition from '@/components/transitions/BasicTransition.vue'
import { Reaction, ReactionUser } from '@/globalTypes'
import axios from 'axios'
import { ref, computed } from 'vue'
import DataTransition from '../transitions/DataTransition.vue'

const $props = defineProps<{
  reactions: Reaction[]
  reactionUsers: ReactionUser[]
  postId: string
}>()
const $emits = defineEmits(['click'])

const reaction_users = ref($props.reactionUsers)
const sorted_reactions = computed(() => reaction_users.value.sort((a,b) => b.total - a.total))

async function doReact(post_id: string, reaction_id: string) {
  const res = await axios.post(route('dashboard.reactions.store'), {
    reaction_id,
    post_id,
  })

  reaction_users.value = res.data
}
</script>
