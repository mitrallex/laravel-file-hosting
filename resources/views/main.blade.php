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

        <div class="field is-pulled-right">
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
        </div>

        <div class="is-clearfix"></div>

        <tabs>
            <tab name="Pictures" :selected="true">
                <h1>Tab number one! - Pictures</h1>
            </tab>
            <tab name="Music">
                <h1>Tab number two! - Music</h1>
            </tab>
            <tab name="Videos">
                <h1>Tab number three! - Videos</h1>
            </tab>
            <tab name="Documents">
                <h1>Tab number three! - Documents</h1>
            </tab>
        </tabs>
    </div>
@endsection
