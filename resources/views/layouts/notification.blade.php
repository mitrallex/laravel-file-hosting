<transition name="fade">
    <div class="container is-fluid" id="message" v-show="notification">

        <div class="notification is-success" v-cloak v-if="!anyError()">
            <button class="delete" @click="notification=false"></button>
            <h1 class="subtitle">
                @{{ message }}
            </h1>
        </div>

        <div class="notification is-danger" v-cloak v-if="anyError()">
            <button class="delete" @click="notification=false"></button>

            <h1 class="subtitle">
                @{{ message }}
            </h1>

            <div class="content">
                <ul v-for="error in errors">
                    <li v-for="error_item in error">
                        @{{ error_item }}
                    </li>
                </ul>
            </div>
        </div>

    </div>
</transition>
