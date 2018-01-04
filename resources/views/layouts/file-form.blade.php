<div class="container is-fluid box">
    <div class="new-file">
        <form id="new-file-form" action="{{ route('file-add') }}" method="post" @click="notification=true">
            <div class="field is-grouped">

                {{ csrf_field() }}

                <p class="control is-expanded">
                    <input class="input" type="text" name="name" placeholder="File name">
                </p>
                <div class="file is-info has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="resume">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Upload new file
                            </span>
                        </span>
                        <span class="file-name">
                            Screen Shot 2017-07-29 at 15.54.25.png
                        </span>
                    </label>
                </div>
                <p class="control">
                    <button class="button is-primary">
                        Add new file
                    </button>
                </p>
            </div>
        </form>
    </div>
</div>
