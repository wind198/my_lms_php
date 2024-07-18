import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue, route } from "../../vendor/tightenco/ziggy/src/js";
import vuetify from "./vuetify";
import "../css/app.css";
import "@mdi/font/css/materialdesignicons.css";
import { processBackendErrorMsg } from "./helper/validation";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

declare global {
    interface Window {
        route: typeof route;
    }
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ) as any,
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .use(ZiggyVue)
            .use({
                install(app) {
                    app.config.globalProperties.$processBackendErrorMsg = (
                        msg: string,
                        itemType?: string
                    ) => processBackendErrorMsg(msg, itemType);
                },
            })
            .mount(el) as any;
    },
    progress: {
        color: "#4B5563",
    },
});
