import './bootstrap'
import '../scss/index.scss'
import { createApp, h } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import PrimeVue from 'primevue/config'
import DialogService from 'primevue/dialogservice'
import ConfirmationService from 'primevue/confirmationservice'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import Tooltip from 'primevue/tooltip'
import ToastService from 'primevue/toastservice'
import Ripple from 'primevue/ripple'
import Lara from '@primevue/themes/lara'
import { definePreset } from '@primevue/themes'

const appName = window.document.getElementsByTagName('title')[0]?.innerText ||
  'Laravel'
const themePreset = definePreset(Lara, {
  semantic: {
    primary: {
      50: '{cyan.50}',
      100: '{cyan.100}',
      200: '{cyan.200}',
      300: '{cyan.300}',
      400: '{cyan.400}',
      500: '{cyan.500}',
      600: '{cyan.600}',
      700: '{cyan.700}',
      800: '{cyan.800}',
      900: '{cyan.900}',
      950: '{cyan.950}',
    },
  },
})

library.add(fas)

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`,
    import.meta.glob('./Pages/**/*.vue')),
  setup({el, App, props, plugin}) {
    return createApp({render: () => h(App, props)}).
      use(plugin).
      use(PrimeVue, {
        theme: {
          preset: themePreset,
        },
      }).
      use(ZiggyVue, Ziggy).
      use(DialogService).
      use(ConfirmationService).
      use(ToastService).
      component('Link', Link).
      component('RouterLink', Link).
      directive('tooltip', Tooltip).
      directive('ripple', Ripple).
      mount(el)
  },
  progress: {
    color: '#06b6d4',
  },
})
