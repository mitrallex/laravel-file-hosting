
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
window.axios = require('axios');

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('tabs', require('./components/Tabs'));
// Vue.component('tab', require('./components/Tab'));

const app = new Vue({
    el: '#app',

    data: {
        files: {},
        activeTab: 'image',

        data: new FormData(),
        attachments: [],

        notification: false
    },

    methods: {
        isActive(tabItem) {
            return this.activeTab === tabItem;
        },

        setActive(tabItem) {
            this.activeTab = tabItem;
        },

        fetchFile(type) {
            axios.get('/practice/public/files/' + type + '/').then(result => {
                this.files = result.data;
            }).catch(error => {
                console.log(error);
            });
        },

        getFiles(type) {
            this.fetchFile(type);
            this.setActive(type);
        }
    },

    mounted() {
        this.fetchFile('image');
    }

});
