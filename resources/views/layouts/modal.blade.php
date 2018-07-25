<div class="modal" :class="{'is-active' : modalActive}">
    <div class="modal-background" @click="closeModal()"></div>
        <div class="modal-content">
            <p class="image is-4by3">
                <img v-if="Object.keys(file).length !== 0" src=""  :src="'{{ asset('storage/' . Auth::user()->name . '_' . Auth::id()) }}' + '/' + file.type + '/' + file.name + '.' + file.extension" :alt="file.name">
            </p>
        </div>
    <button class="modal-close is-large" aria-label="close" @click="closeModal()"></button>
</div>
