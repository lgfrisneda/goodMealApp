require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        console.log(props.initialPage.props.messages);
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { 
                route,
                twoDecimals(value){
                    return Math.floor(value*100)/100;
                },
            } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
