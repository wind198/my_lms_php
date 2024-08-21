import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue, route } from "../../vendor/tightenco/ziggy/src/js";
import vuetify from "./vuetify";
import "../css/app.scss";
import "@mdi/font/css/materialdesignicons.css";
import { processBackendErrorMsg } from "./helper/validation";
import SimpleLayoutForLogin from "./Layouts/SimpleLayoutForLogin.vue";
import ColumnsLayoutForDashboard from "./Layouts/ColumnsLayoutForDashboard.vue";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

declare global {
    interface Window {
        route: typeof route;
    }
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page: any = pages[`./Pages/${name}.vue`];
        page.default.layout =
            page.default.layout ??
            (name.startsWith("Auth/")
                ? SimpleLayoutForLogin
                : ColumnsLayoutForDashboard);
        return page;
    },
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
