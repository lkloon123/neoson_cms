@extends('layouts.auth')

@section('content')
    <body class="fp-page ls-closed">
    <div class="fp-box">
        <div class="logo">
            <a href="#">NeoSon<b>CMS</b></a>
        </div>
        <div class="card">
            <div class="body">
                <div class="msg">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                </div>

                <button onclick="window.location = '{{ route('verification.resend') }}'"
                        class="btn btn-primary btn-block btn-lg waves-effect">
                    {{ __('click here to request another') }}
                </button>
            </div>
        </div>
    </div>

    @if (session('resent'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                $.notify({
                        message: '{{ __('A verification link has been sent to your email address.') }}'
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
