@extends('layouts.auth')

@section('content')
    <body class="login-page ls-closed">
    <div class="login-box">
        <div class="logo">
            <a href="#">NeoSon<b>CMS</b></a>
        </div>
        <div class="card">
            <div class="body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="msg">{{ __('Login') }}</div>
                    <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                        <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                            <input id="email" type="email"
                                   class="form-control" name="email"
                                   placeholder="Email"
                                   value="{{ old('email') }}" required autofocus>
                        </div>

                        @if ($errors->has('email'))
                            <label for="email" class="error">
                                {{ $errors->first('email') }}
                            </label>
                        @endif
                    </div>

                    <div class="input-group">
                                <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>

                        <div class="form-line{{ $errors->has('password') ? ' error' : '' }}">
                            <input id="password" type="password"
                                   class="form-control" placeholder="Password"
                                   name="password" required>
                        </div>

                        @if ($errors->has('password'))
                            <label for="password" class="error">
                                {{ $errors->first('password') }}
                            </label>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input class="filled-in chk-col-pink" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block waves-effect">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>

                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        </div>
                        <div class="col-xs-6 align-right">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection
