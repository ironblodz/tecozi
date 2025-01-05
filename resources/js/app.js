import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import i18n from './i18n';
import { createVuetify } from 'vuetify';
import MaintenancePage from '@/Components/errors/MaintenancePage.vue';
import { createMetaManager } from 'vue-meta';

const appName = import.meta.env.VITE_APP_NAME || 'Tecozi';

// Verificar se o Laravel está em modo de manutenção
const isMaintenance = document.querySelector('meta[name="maintenance-mode"]')?.content === 'true';

if (isMaintenance) {
    // Renderiza a página de manutenção
    const app = createApp(MaintenancePage);
    app.use(createVuetify);
    app.use(createMetaManager());
    app.mount('#app');
} else {
    // Inicializa o Inertia.js normalmente
    createInertiaApp({
        title: (title) => `${title} - ${appName}`,
        resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
        setup({ el, App, props, plugin }) {
            const app = createApp({ render: () => h(App, props) });

            app.use(plugin);
            app.use(ZiggyVue);
            app.use(i18n);
            app.use(createVuetify);
            app.use(createMetaManager()); // Use vue-meta

            app.mount(el);
        },
        progress: {
            color: '#4B5563',
        },
    });
}
