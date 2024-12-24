import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import i18n from './i18n';
import { createVuetify } from 'vuetify';

const appName = import.meta.env.VITE_APP_NAME || 'Tecozi';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        // Create the Vue application
        const app = createApp({ render: () => h(App, props) });

        // Use Inertia plugin
        app.use(plugin);

        // Use Ziggy for routing
        app.use(ZiggyVue);

        app.use(i18n);

        app.use(createVuetify);

        // Mount the app to the DOM
        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
