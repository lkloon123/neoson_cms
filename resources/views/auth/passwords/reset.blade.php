@extends('layouts.auth')

@section('content')
    <body class="fp-page">
    <div class="fp-box">
        <div class="logo">
            <a href="#">NeoSon<b>CMS</b></a>
        </div>
        <div class="card">
            <div class="body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="msg">{{ __('Reset Password') }}</div>

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>

                        <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                            <input id="email" type="email"
                                   class="form-control" name="email"
                                   value="{{ $email ?? old('email') }}" placeholder="Email" required>
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

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>

                        <div class="form-line{{ $errors->has('password_confirmation') ? ' error' : '' }}">
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" placeholder="Confirm Password" required>
                        </div>

                        @if ($errors->has('password_confirmation'))
                            <label for="password-confirm" class="error">
                                {{ $errors->first('password_confirmation') }}
                            </label>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg waves-effect">
                        {{ __('Reset Password') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection
