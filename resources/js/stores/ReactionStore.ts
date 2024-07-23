import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'
import { Reaction } from '@/globalTypes'

export const useReactionStore = defineStore('reaction', () => {
  const reactions = ref<Reaction[]>([])

  async function getReactions() {
    const res = await axios.get(route('dashboard.reactions.index'))
    reactions.value = res.data
  }

  return { reactions, getReactions }
})
