
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

const app = new Vue({
    el: '#app',

    data: {
        files: {},
        activeTab: 'image',

        formData: {},
        fileName: '',
        attachment: '',

        notification: false,
        message: ''
    },

    methods: {
        isActive(tabItem) {
            return this.activeTab === tabItem;
        },

        setActive(tabItem) {
            this.activeTab = tabItem;
        },

        fetchFile(type) {
            axios.get('/public/files/' + type + '/').then(result => {
                this.files = result.data;
            }).catch(error => {
                console.log(error);
            });
        },

        getFiles(type) {
            this.fetchFile(type);
            this.setActive(type);
        },

        submitForm() {
            this.formData = new FormData();
            this.formData.append('name', this.fileName);
            this.formData.append('file', this.attachment);

            axios.post('/public/files/add', this.formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }}).then(response => {
                    this.showNotification('File successfully upload!');
                    this.resetForm();
                    this.fetchFile(this.activeTab);
                }).catch(error => {
                    console.log(error);
                });
        },

        addFile() {
            this.attachment = this.$refs.file.files[0];
        },

        deleteFile(id) {
            // console.log(window.axios.defaults.headers);
            axios.post('/public/files/delete/' + id)
                .then(response => {
                    this.showNotification('File successfully deleted!');
                    this.fetchFile(this.activeTab);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        showNotification(text) {
            var application = this;
            application.message = text;
            application.notification = true;
            setTimeout(function() {
                application.notification = false;
            }, 30000);
        },

        resetForm() {
            this.formData = {};
			this.fileName = '';
            this.attachment = '';
        }
    },

    mounted() {
        this.fetchFile('image');
    }

});
