require('./bootstrap');

import Vue from 'vue';
import { App, plugin } from '@inertiajs/inertia-vue';
import VueAWN from "vue-awesome-notifications";
import { InertiaProgress } from '@inertiajs/progress';
import { asset } from '@codinglabs/laravel-asset';
import { ValidationProvider, ValidationObserver } from "vee-validate";
import LaravelVuePagination from 'laravel-vue-pagination';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import VueMoment from 'vue-moment';
import VueHtml2pdf from 'vue-html2pdf';
import JsonExcel from "vue-json-excel";
import VueQrcode from 'vue-qrcode';
import VueLoading from 'vue-loading-template';
import VueCharts from 'vue-chartjs';
import VTooltip from 'v-tooltip';

InertiaProgress.init({
  delay: 250,
  color: '#29d',
  includeCSS: true,
  showSpinner: false,
});

Vue.use(plugin);
Vue.use(VueAWN);
Vue.use(VueMoment);
Vue.use(VueLoading);
Vue.use(VTooltip);

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('pagination', LaravelVuePagination);
Vue.component('v-select', vSelect);
Vue.component('vue-qrcode', VueQrcode)
Vue.component('vue-html2pdf', VueHtml2pdf);
Vue.component("downloadExcel", JsonExcel);
Vue.component("vue-charts", VueCharts);

Vue.mixin({
  methods: {
    route, asset
  }
});

const el = document.getElementById('app');

new Vue({
  render: h => h(App, {
    props: {
      initialPage: JSON.parse(el.dataset.page),
      resolveComponent: name => require(`./Pages/${name}`).default,
    },
  }),
}).$mount(el);
