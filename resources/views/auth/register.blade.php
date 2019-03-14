@extends('layouts.auth')

@section('content')
    <body>
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        NeoSon<strong>CMS</strong>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header"><h4>Register</h4></div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" name="name"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           value="{{ old('name') }}" tabindex="1" required autofocus>

                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" name="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           value="{{ old('email') }}" tabindex="2" required autofocus>

                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password" class="control-label">Password</label>
                                    <input id="password" type="password" name="password"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           tabindex="3" required>

                                    @if ($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">Confirm Password</label>
                                    <input id="password-confirm" type="password" name="password_confirmation"
                                           class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                           tabindex="4" required>

                                    @if ($errors->has('password_confirmation'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password_confirmation') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="5">
                                        {{ __('Register') }}
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="mt-5 text-muted text-center">
                        @if (Route::has('register'))
                            Already have an account? <a href="{{ route('login') }}">Login</a>
                        @endif
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; NeoSon 2019
                    </div>
                </div>
            </div>
        </div>
    </section>
    </body>
@endsection
