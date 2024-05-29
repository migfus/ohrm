import './bootstrap'

import { createApp, h, DefineComponent } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
import Layout from '@/layout/BaseLayout.vue'
import Notifications from 'notiwind'

createInertiaApp({
  resolve: async name => {
    const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue')
    let page = (await pages[`./Pages/${name}.vue`]()).default
    page.layout = page.layout || Layout
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(Notifications)
      .component('Link', Link)
      .component('Head', Head)
      .mount(el)
  },
  progress: {
    color: '#CA8A05'
  }
})
