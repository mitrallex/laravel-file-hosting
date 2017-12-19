@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns">
        <div class="column is-three-fifths is-offset-one-fifth">
            <div class="box">
                <h2 class="title">Reset Password</h2>

                @if (session('status'))
                    <article class="message is-success">
                        <div class="message-body">
                            {{ session('status') }}
                        </div>
                    </article>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    <div class="field">
                        <p class="control has-icons-left has-icons-right">
                            <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="email" name="email" placeholder="Email Address">
                            <span class="icon is-small is-left">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </p>
                        @if ($errors->has('email'))
                            <p class="help is-danger">
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    <div class="field">
                        <p class="control">
                            <button class="button is-primary" type="submit">
                                Send Password Reset Link
                            </button>
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
