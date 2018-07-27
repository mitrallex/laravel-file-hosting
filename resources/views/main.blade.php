@extends('layouts.app')

@section('content')
    <div class="container is-fluid box">
        <div class="tabs is-centered is-large">
            <ul>
                <li :class="{'is-active': isActive('image')}" @click="getFiles('image')">
                    <a>
                        <span class="icon is-small"><i class="fa fa-image"></i></span>
                        <span>Pictures</span>
                    </a>
                </li>
                <li :class="{'is-active': isActive('audio')}" @click="getFiles('audio')">
                   <a>
                        <span class="icon is-small"><i class="fa fa-music"></i></span>
                        <span>Music</span>
                    </a>
                </li>
                <li :class="{'is-active': isActive('video')}" @click="getFiles('video')">
                    <a>
                        <span class="icon is-small"><i class="fa fa-film"></i></span>
                        <span>Videos</span>
                    </a>
                </li>
                <li :class="{'is-active': isActive('document')}" @click="getFiles('document')">
                    <a>
                        <span class="icon is-small"><i class="fa fa-file-text-o"></i></span>
                        <span>Documents</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tabs-details">
            <div class="columns is-multiline">

                <div class="is-empty column is-4 is-offset-4" v-if="pagination.total == 0" v-cloak>
                    <figure>
                        <img src="{{ asset('images/folder_empty.png') }}" alt="Folder empty" id="folder_empty">
                        <figcaption>
                            <p class="title is-2">
                                This folder is empty!
                            </p>
                        </figcaption>
                    </figure>
                </div>

                <div class="loading column is-4 is-offset-4" v-if="loading">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>
                <br>
                <div class="column " :class="isVideo  ? 'is-half'  : 'is-one-fifth'" v-for="file in files" >
                    <div class="card " :class="file.type == 'image' ? 'is-image' : ''">
                        <div class="card-image">
                            <button class="delete delete-file" title="Delete" @click="prepareToDelete(file)"></button>
                            <figure class="image is-4by3" v-if="file.type == 'image'" @click="showModal(file)">
                                <img v-if="file === editingFile" src=""  :src="'{{ asset('storage/' . Auth::user()->name . '_' . Auth::id()) }}' + '/' + savedFile.type + '/' + savedFile.name + '.' + savedFile.extension" :alt="file.name">
                                <img v-if="file !== editingFile" src=""  :src="'{{ asset('storage/' . Auth::user()->name . '_' . Auth::id()) }}' + '/' + file.type + '/' + file.name + '.' + file.extension" :alt="file.name">
                            </figure>

                            <div v-if="file.type == 'audio'">
                                <figure class="image is-4by3">
                                    <img src="{{ asset('images/music.png') }}" alt="Audio image" id="audio_image">
                                </figure>
                                <audio controls>
                                    <source src="" :src="'{{ asset('storage/' . Auth::user()->name . '_' . Auth::id()) }}' + '/' + file.type + '/' + file.name + '.' + file.extension" :type="'audio/' + file.extension">
                                    Your browser does not support the audio tag.
                                </audio>
                            </div>

                            <div v-if="file.type == 'video'" class="video_block">
                                <video controls>
                                    <source src="" :src="'{{ asset('storage/' . Auth::user()->name . '_' . Auth::id()) }}' + '/' + file.type + '/' + file.name + '.' + file.extension" :type="'video/' + file.extension">
                                    Your browser does not support the video tag.
                                </video>
                            </div>

                            <div v-if="file.type == 'document'" class="document_block">
                                <figure class="image is-4by3">
                                    <img src="{{ asset('images/document.png') }}" alt="Audio image" id="audio_image">
                                </figure>
                                <a class="button is-primary" href="" :href="'{{ asset('storage/' . Auth::user()->name . '_' . Auth::id()) }}' + '/' + file.type + '/' + file.name + '.' + file.extension" target="_blank">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    &nbsp;Download
                                </a>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="content">
                                <p v-if="file !== editingFile" @dblclick="editFile(file)" :title="'Double click for editing filename'">
                                    @{{ file.name + '.' + file.extension}}
                                </p>
                                <input class="input" v-if="file === editingFile" v-autofocus @keyup.enter="endEditing(file)" @blur="endEditing(file)" type="text" :placeholder="file.name" v-model="file.name">
                                <time datetime="2016-1-1">@{{ file.created_at }}</time>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="pagination is-centered" role="navigation" aria-label="pagination" v-if="pagination.last_page > 1" v-cloak>
            <a class="pagination-previous" @click.prevent="changePage(1)" :disabled="pagination.current_page <= 1">First page</a>
            <a class="pagination-previous" @click.prevent="changePage(pagination.current_page - 1)" :disabled="pagination.current_page <= 1">Previous</a>
            <a class="pagination-next" @click.prevent="changePage(pagination.current_page + 1)" :disabled="pagination.current_page >= pagination.last_page">Next page</a>
            <a class="pagination-next" @click.prevent="changePage(pagination.last_page)" :disabled="pagination.current_page >= pagination.last_page">Last page</a>
            <ul class="pagination-list">
                <li v-for="page in pages">
                    <a class="pagination-link" :class="isCurrentPage(page) ? 'is-current' : ''" @click.prevent="changePage(page)">
                        @{{ page }}
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@endsection
