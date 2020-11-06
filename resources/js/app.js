import Index from './Index';
import VueRouter from "vue-router";
import {router} from "./routes";
import {store} from './store';
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css';
import VueCookie from 'vue-cookie';

require('./bootstrap');

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(VueCookie);
Vue.use(Datetime);

router.beforeEach((to, from, next) => {
    store.state.success = false;
    store.state.errors = false;
    next();
})

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        "index" : Index
    }
})
