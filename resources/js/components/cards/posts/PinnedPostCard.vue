<template>
  <!-- ✅ -->
  <div class="bg-white shadow sm:rounded-2xl text-brand-800 transition-all">
    <!-- NOTE: PINNED POST CARD HEADER -->
    <div class="flex font-medium justify-between px-4 pt-4 pb-2">
      <Link :href="route('dashboard.manage-users.edit', {manage_user: post.user.id})" class="flex">
        <img :src="post.user.avatar" class="h-8 w-8 rounded-full shadow mr-2" />
        <div class="flex flex-col">
          <span class="text-sm">{{ post.user.name }}</span>
          <span class="text-xs">{{ moment(post.created_at).fromNow(true) }}</span>
        </div>
      </Link>
      <div class="text-sm font-regular py-0 my-0 cursor-pointer gap-1 flex text-brand-500" @click="PostStore.pinPostApi(post.id, groupId)">
        <MapPinIcon class="h-4 w-4 inline"/>
        <XMarkIcon class="h-4 w-4 inline"/>
      </div>
    </div>

    <!-- NOTE: PINNED POST CARD CONTENTS -->
    <div ref="sentenceLines" class="m-1 bg-white px-4 py-2 rounded-lg ">
      <div v-if="minimize_content" v-html="post.title" class="line-clamp-4" ></div>
      <div v-else v-html="post.title"></div>
    </div>

    <button v-if="height > 95" class="mx-4 text-sm" @click="minimize_content = !minimize_content">{{ minimize_content ? 'Show More...' : 'Show Less...'}}</button>

    <!-- NOTE: PINNED POST CARD FOOTER -->
    <div class="flex justify-between mx-4 py-2 text-sm gap-4">
      <span class="text">
        <DataTransition v-if="sorted_reactions.length > 0" class="flex">
          <div
            v-for="user_reaction in sorted_reactions"
            :key="user_reaction.id"
            :class="'cursor-pointer rounded-2xl pl-2 pr-1'"
          >
            <!-- NOTE: COUNT -->
            <label>
              {{ user_reaction.total }}
            </label>
            <!-- NOTE: REACTION EMOJI -->
            <label class="text-md inline cursor-pointer">
              {{ user_reaction.reaction.content }}
            </label>

            <!-- ReactionID: [{{ user_reaction.reaction_id }} = {{ auth_reaction }}] -->
          </div>
        </DataTransition>
      </span>
      <span>
        <span class="inline">{{ post.comments_count }}</span>
        <ChatBubbleLeftRightIcon class="w-4 h-4 inline ml-1 text-brand-500"/>
      </span>
    </div>

  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Post } from '@/globalTypes'
import moment from 'moment'
import { useElementSize } from '@vueuse/core'
import { usePostStore } from '@/stores/PostStore'

import { XMarkIcon, ChatBubbleLeftRightIcon, MapPinIcon } from '@heroicons/vue/24/solid'
import DataTransition from '@/components/transitions/DataTransition.vue'

const $props = defineProps<{
  post: Post
  groupId: string
}>()

const PostStore = usePostStore()

const minimize_content = ref(true)
const sentence_lines = ref(null)
const { height } = useElementSize(sentence_lines)

const sorted_reactions = computed(() => $props.post.reaction_users.sort((a,b) => b.total - a.total)) // sorted version of reactions
</script>
