@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns">
        <div class="column is-three-fifths is-offset-one-fifth">
            <div class="box">
                <h2 class="title">Login</h2>

                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="field">
                        <p class="control has-icons-left has-icons-right">
                            <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
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
                        <p class="control has-icons-left">
                            <input class="input {{ $errors->has('password') ? ' is-danger' : '' }}" type="password" name="password" placeholder="Password" required>
                            <span class="icon is-small is-left">
                                <i class="fa fa-lock"></i>
                            </span>
                        </p>
                        @if ($errors->has('password'))
                            <p class="help is-danger">
                                {{ $errors->first('password') }}
                            </p>
                        @endif
                    </div>
                    <div class="field">
                        <p class="control">
                            <label class="checkbox">
                                <input type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                Remember me
                            </label>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control">
                            <a href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control">
                            <a class="button is-primary" href="{{ route('register') }}">
                                Register
                            </a>
                            <button class="button is-primary">
                                Login
                            </button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
