import './bootstrap'
import '../scss/index.scss'
import {createApp, h} from 'vue'
import {createInertiaApp, Link} from '@inertiajs/vue3'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers'
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m'
import PrimeVue from 'primevue/config'
import DialogService from 'primevue/dialogservice'
import ConfirmationService from 'primevue/confirmationservice'
import {library} from '@fortawesome/fontawesome-svg-core';
import {fas} from '@fortawesome/free-solid-svg-icons';
import Tooltip from 'primevue/tooltip';
import ToastService from 'primevue/toastservice';
import Ripple from 'primevue/ripple';
import Lara from '@primevue/themes/lara'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

library.add(fas)

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(PrimeVue, {
                theme: {
                    preset: Lara
                }
            })
            .use(ZiggyVue, Ziggy)
            .use(DialogService)
            .use(ConfirmationService)
            .use(ToastService)
            .component('Link', Link)
            .component('RouterLink', Link)
            .directive('tooltip', Tooltip)
            .directive('ripple', Ripple)
            .mount(el)
    },
    progress: {
        color: '#06b6d4',
    },
})
