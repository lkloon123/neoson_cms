@extends('layouts.auth')

@section('content')
    <body class="fp-page">
    <div class="fp-box">
        <div class="logo">
            <a href="#">NeoSon<b>CMS</b></a>
        </div>
        <div class="card">
            <div class="body">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="msg">{{ __('Reset Password') }}</div>

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>

                        <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                            <input id="email" type="email"
                                   class="form-control" name="email" placeholder="Email"
                                   value="{{ old('email') }}" required>
                        </div>

                        @if ($errors->has('email'))
                            <label for="email" class="error">
                                {{ $errors->first('email') }}
                            </label>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg waves-effect">
                        {{ __('Send Password Reset Link') }}
                    </button>

                    <div class="row m-t-20 m-b--5 align-center">
                        <a href="{{ route('login') }}">Back to login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('status'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                $.notify({
                        message: '{{ session('status') }}'
                    },
                    {
                        type: 'alert-success',
                        allow_dismiss: true,
                        newest_on_top: true,
                        timer: 1000,
                        placement: {
                            from: 'bottom',
                            align: 'center'
                        },
                        animate: {
                            enter: 'animated fadeInUp',
                            exit: 'animated fadeOutDown'
                        },
                        template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} p-r-35" role="alert">' +
                            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                            '<span data-notify="icon"></span> ' +
                            '<span data-notify="title">{1}</span> ' +
                            '<span data-notify="message">{2}</span>' +
                            '<div class="progress" data-notify="progressbar">' +
                            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                            '</div>' +
                            '<a href="{3}" target="{4}" data-notify="url"></a>' +
                            '</div>'
                    });
            });
        </script>
    @endif

    </body>
@endsection
