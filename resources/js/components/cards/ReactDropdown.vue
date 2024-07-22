<template>
  <Menu as="div" class="relative inline-block text-left">
    <div>
      <!-- SECTION: USERS REACTIONS -->
      <MenuButton class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-brand-50 text-sm font-semibold text-brand-900 hover:bg-brand-50 ">
        <DataTransition v-if="reaction_users.length > 0" class="flex">
          <div
            v-for="user_reaction in sorted_reactions"
            :key="user_reaction.id"
            :class="[auth_reaction === user_reaction.reaction_id && 'bg-white shadow', 'cursor-pointer rounded-2xl pl-2 pr-1']"
          >
            <!-- NOTE: COUNT -->
            <label>
              {{ user_reaction.total }}
            </label>
            <!-- NOTE: REACTION EMOJI -->
            <label class="text-lg inline cursor-pointer">
              {{ user_reaction.reaction.content }}
            </label>

            <!-- ReactionID: [{{ user_reaction.reaction_id }} = {{ auth_reaction }}] -->
          </div>
        </DataTransition>

        <FaceSmileIcon v-else class="-mr-1 h-6 w-6 text-brand-400" aria-hidden="true" />
      </MenuButton>
    </div>

    <BasicTransition>

      <!-- SECTION: REACTIONS -->
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
import { usePage } from '@inertiajs/vue3'
import SharedProps from '@/SharedProps'

const $props = defineProps<{
  reactions: Reaction[]
  reactionUsers: ReactionUser[]
  postId: string
  authReactionId?: number
}>()
const $emits = defineEmits(['click'])
const page = usePage<SharedProps>()

const reaction_users = ref($props.reactionUsers)
const sorted_reactions = computed(() => reaction_users.value.sort((a,b) => b.total - a.total))
const auth_reaction = ref<number>($props.authReactionId ?? 0)

async function doReact(post_id: string, reaction_id: number) {
  const res = await axios.post(route('dashboard.reactions.store'), {
    reaction_id,
    post_id,
  })

  reaction_users.value = res.data

  // SECTION: For Auth Reaction
  if(reaction_id == auth_reaction.value) {
    auth_reaction.value = 0
  }
  else {
    auth_reaction.value = reaction_id
  }
}
</script>
