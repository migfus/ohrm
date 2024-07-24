import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'
import { Reaction } from '@/globalTypes'

export const useReactionStore = defineStore('reaction', () => {
  const reaction_data = ref<Reaction[]>([])

  async function getReactions() {
    const res = await axios.get(route('dashboard.reactions.index'))
    reaction_data.value = res.data
  }

  return { reaction_data, getReactions }
})
