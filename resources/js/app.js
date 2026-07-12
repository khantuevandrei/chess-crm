import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import PrimeVue from "primevue/config";
import Aura from "@primevue/themes/aura";
import "primeicons/primeicons.css";
import "primeflex/primeflex.css";
import "../css/dashboard.css";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue");
        const importPage = pages[`./Pages/${name}.vue`];
        if (!importPage) {
            throw new Error(`Page not found: ${name}`);
        }
        return importPage().then((module) => module.default);
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        darkModeSelector: ".app-dark", // тёмная только если есть класс app-dark
                    },
                },
            })
            .mount(el);
    },
});
