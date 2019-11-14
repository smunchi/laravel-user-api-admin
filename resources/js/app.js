require('./bootstrap');

import Vue from 'vue'

import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))



Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    el: '#app',
});
