import type { route as routeFn } from 'ziggy-js';
import type { Config } from 'ziggy-js';

declare global {
    const route: typeof routeFn;
    interface Window {
        Ziggy: Config;
    }
}
