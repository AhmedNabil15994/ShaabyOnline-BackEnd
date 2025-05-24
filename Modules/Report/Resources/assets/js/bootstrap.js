window._ = require('lodash');



/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.$origin = window.location.origin
window.axios = axios.create({
    baseURL: window.location.origin + "/api/"
    // baseURL:"https://jsonplaceholder.typicode.com/" ,
});


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.defaults.headers.common['Accept'] = 'application/json';


window.axios.defaults.headers.common['Accept-Language'] = document.documentElement.lang;
window.axios.defaults.headers.common['X-CSRF-Token'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');