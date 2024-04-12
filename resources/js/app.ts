import './bootstrap'

import { createApp, h, DefineComponent } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/vue3'
import Layout from '@/layout/BaseLayout.vue'
import Notifications from 'notiwind'


createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || Layout
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(Notifications)
      .component('Link', Link)
      .mount(el)
  },
  progress: {
    color: '#f00'
  }
})
