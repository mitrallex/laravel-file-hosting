<transition name="fade">
    <div class="container is-fluid" id="message" v-show="notification">
        <div class="notification is-success" v-cloak>
            <button class="delete" @click="notification=false"></button>
            @{{ message }}
        </div>
    </div>
</transition>
