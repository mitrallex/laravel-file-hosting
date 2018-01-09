@extends('layouts.app')

@section('content')
    <div class="container is-fluid box">
        @if (session('status'))
            <article class="message is-success">
                <div class="message-body">
                    {{ session('status') }}
                </div>
            </article>
        @endif


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
            <div class="columns is-multiline is-mobile">
                <div class="column is-one-quarter" v-for="file in files">
                    <div class="card">
                        <div class="card-image">
                            <button class="delete delete-file" title="Delete" @click="deleteFile(file.id)"></button>
                            <figure class="image is-4by3">
                                <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                            </figure>
                      </div>
                      <div class="card-content">
                            <div class="content">
                                @{{ file.name }}
                                <br>
                                <time datetime="2016-1-1">@{{ file.created_at }}</time>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
