
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

    directives: {
            'autofocus': {
                inserted(el) {
                    el.focus();
                }
            }
    },

    data: {
        files: {},
        activeTab: 'image',
        isVideo: false,

        formData: {},
        fileName: '',
        attachment: '',

        editingFile: {},

        notification: false,
        showConfirm: false,
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
            axios.get('files/' + type + '/').then(result => {
                this.files = result.data;
            }).catch(error => {
                console.log(error);
            });
        },

        getFiles(type) {
            this.setActive(type);
            this.fetchFile(type);

            if (this.activeTab === 'video') {
                this.isVideo = true;
            } else {
                this.isVideo = false;
            }
        },

        submitForm() {
            this.formData = new FormData();
            this.formData.append('name', this.fileName);
            this.formData.append('file', this.attachment);

            axios.post('files/add', this.formData, {
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

        prepareToDelete(file) {
            this.editingFile = file;
            this.showConfirm = true;
        },

        cancelDeleting() {
            this.editingFile = {};
            this.showConfirm = false;
        },

        deleteFile() {
            axios.post('files/delete/' + this.editingFile.id)
                .then(response => {
                    this.showNotification('File successfully deleted!');
                    this.fetchFile(this.activeTab);
                })
                .catch(error => {
                    console.log(error);
                });

            this.cancelDeleting();
        },

        editFile(file) {
            this.editingFile = file;
        },

        endEditing(file) {
            this.editingFile = {};

            if (file.name.trim() === '') {
                alert('Filename cannot be empty!');
                this.fetchFile(this.activeTab);
            } else {
                var formData = new FormData();
                formData.append('name', file.name);
                formData.append('type', file.type);
                formData.append('extension', file.extension);

                axios.post('files/edit/' + file.id, formData)
                    .then(response => {
                        if (response.data === true) {
                            this.showNotification('Filename successfully changed!')
                            
                            var src = document.querySelector('[alt="' + file.name +'"]').getAttribute("src");
                            document.querySelector('[alt="' + file.name +'"]').setAttribute('src', src);
                        }
                        this.fetchFile(this.activeTab);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },

        showNotification(text) {
            var application = this;
            application.message = text;
            application.notification = true;
            setTimeout(function() {
                application.notification = false;
            }, 15000);
        },

        resetForm() {
            this.formData = {};
			this.fileName = '';
            this.attachment = '';
        }
    },

    mounted() {
        this.fetchFile(this.activeTab);
    }
});
