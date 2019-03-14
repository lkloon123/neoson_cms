@extends('layouts.auth')

@section('content')
    <body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            NeoSon<strong>CMS</strong>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header"><h4>Login</h4></div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" name="email"
                                               class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               value="{{ old('email') }}" tabindex="1" required autofocus>

                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}" class="text-small">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <input id="password" type="password" name="password"
                                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               tabindex="2" required>

                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                   tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                   for="remember">{{ __('Remember Me') }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="mt-5 text-muted text-center">
                            @if (Route::has('register'))
                                Don't have an account? <a href="{{ route('register') }}">Register</a>
                            @endif
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; NeoSon 2019
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </body>
@endsection
