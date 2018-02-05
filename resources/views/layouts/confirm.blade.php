<transition name="modal">
    <div class="modal-mask" v-if="showConfirm" v-cloak>
        <div class="modal-wrapper">
            <div class="modal-container">

                <div class="modal-body">
                    <h2>Are you sure?</h2>
                </div>

                <div class="modal-footer">
                    <button class="button" @click="deleteFile()">
                        Confirm
                    </button>
                    <button class="button" @click="cancelDeleting()">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</transition>
