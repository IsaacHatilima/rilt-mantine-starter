import '../css/app.css';
import './bootstrap';

import { NotificationProvider } from '@/Context/NotificationContext';
import { createInertiaApp } from '@inertiajs/react';
import { MantineProvider } from '@mantine/core';
import '@mantine/core/styles.css';
import '@mantine/dates/styles.css';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot, hydrateRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.tsx`,
            import.meta.glob('./Pages/**/*.tsx'),
        ),
    setup({ el, App, props }) {
        const RootComponent = (
            <NotificationProvider>
                <MantineProvider>
                    <App {...props} />
                </MantineProvider>
            </NotificationProvider>
        );

        if (import.meta.env.SSR) {
            hydrateRoot(el, RootComponent);
        } else {
            createRoot(el).render(RootComponent);
        }
    },
    progress: {
        color: '#4B5563',
    },
});
