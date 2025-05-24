/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.onload = function(){
    window.productAddonModal = $("#product-addon")
    window.paymentModal = $("#pay-methods")
    window.refundModal = $("#refund-modal")

   
}
window.currency = document.documentElement.dataset.currency;
window.totalPaied =  document.documentElement.dataset.total ;
window.auth = JSON.parse(document.documentElement.dataset.user) ;
Vue.config.devtools = true;


// globle plugin 
import i18n from './i18n/i18n'
import InfiniteLoading from 'vue-infinite-loading';
import VueToast from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';

var options = {
  position:'top-left' ,
  queue:false
};

Vue.use(VueToast, options);
Vue.use(InfiniteLoading, { /* options */ });
// invoice 

import VueHtmlToPaper from 'vue-html-print';

const Pdfoptions = {
  name: '_blank',
  specs: [
    'fullscreen=0',
    'titlebar=yes',
    'scrollbars=yes',
    "menubar=0",
  ],
  styles: [
    // "/pos/css/bootstrap.min.css" ,
    // "/pos/css/themify-icons.css",
    // "/pos/css/invoice.css?v=1.2",
    "/pos/css/invoice2.css?v=2.1"
  ],
  timeout: 1000, // default timeout before the print window appears
  autoClose: true, // if false, the window will not close after printing
  windowTitle: window.document.title, // override the window title
}
Vue.use(VueHtmlToPaper, Pdfoptions);

const PrintSettings = {
    printable:"invoice" ,
    type:"html" ,
    scanStyles:true,
    css:[
        '/pos/css/bootstrap.min.css',
        '/pos/css/themify-icons.css',
        // '/pos/css/invoice.css'
    ],
    style:` @page {
        size: auto !important ;
      }`,
    windowTitle: window.document.title
}   

import PrintJs from "./plugins/PrintJs";

Vue.use(PrintJs,PrintSettings );







/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('exemple', require('./components/ExampleComponent.vue').default);
Vue.component('products', require('./components/products/Products.vue').default);
Vue.component('orders', require('./components/orders/Orders.vue').default);
Vue.component('editProfile', require('./components/modals/editProfileModal.vue').default);
Vue.component('loading-screen', require('./components/loading/LoadingScreen.vue').default);
import {DoubleBounce, Stretch} from 'vue-loading-spinner'
Vue.component('loading', Stretch);

// directive
Vue.directive('select2', {
    inserted(el) {
        $(el).on('select2:select', () => {
            const event = new Event('change', { bubbles: true, cancelable: true });
            el.dispatchEvent(event);
        });

        $(el).on('select2:unselect', () => {
            const event = new Event('change', {bubbles: true, cancelable: true})
            el.dispatchEvent(event)
        })
    },
    
});

// mixin glaoble 
Vue.mixin({
    data(){
        return {
            currency:window.currency
        }
    }
  })
// window.toast = new Toasty();

window.app = new Vue({
    el: '#appVue',
    i18n,
    data(){
        return {
            totalPaied: Number(window.totalPaied ),
            auth:auth
        }
    },
    computed:{
        totalDisplay(){
            return `${this.totalPaied}`
        }
    },
    methods:{
        handleUpdatTotal(total){
           this.totalPaied += total
        }
    }
});
