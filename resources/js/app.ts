import './bootstrap'

import { createApp, h, DefineComponent } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
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
      .component('Head', Head)
      .mount(el)
  },
  progress: {
    color: '#CA8A05'
  }
})
