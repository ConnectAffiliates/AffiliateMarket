import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import { InertiaProgress } from '@inertiajs/progress';
import { initializeTheme } from './composables/useAppearance';

// Import Notus styles
import "@fortawesome/fontawesome-free/css/all.min.css";
import "./notus/assets/styles/tailwind.css";

// Extend ImportMeta interface for Vite...
// declare module 'vite/client' {
//     interface ImportMetaEnv {
//         readonly VITE_APP_NAME: string;
//         [key: string]: string | boolean | undefined;
//     }

//     interface ImportMeta {
//         readonly env: ImportMetaEnv;
//         readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
//     }
// }

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        // Try to resolve from pages directory first (lowercase)
        try {
            const page = await resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')) as any;
            return page.default || page;
        } catch (e) {
            // If not found, try to resolve from Pages directory (uppercase)
            try {
                const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')) as any;
                return page.default || page;
            } catch (e) {
                // If not found in either pages or Pages, try to resolve from notus/views directory
                const notusPage = await resolvePageComponent(`./notus/views/${name}.vue`, import.meta.glob('./notus/views/**/*.vue')) as any;
                return notusPage.default || notusPage;
            }
        }
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.use(ZiggyVue);
        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

InertiaProgress.init({ color: '#4B5563' });

// This will set light / dark mode on page load...
initializeTheme();
