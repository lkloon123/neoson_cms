@extends('layouts.auth')

@section('content')
    <body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="login-brand">
                    NeoSon<strong>CMS</strong>
                </div>

                <div class="card card-primary">
                    <div class="card-header"><h4>{{ __('Reset Password') }}</h4></div>

                    <div class="card-body">
                        <p class="text-muted">{{ __('Before proceeding, please check your email for a verification link.') }}</p>

                        <button onclick="window.location = '{{ route('verification.resend') }}'"
                                class="btn btn-primary btn-lg btn-block" tabindex="1">
                            {{ __('click here to request another') }}
                        </button>
                    </div>
                </div>

                <div class="simple-footer">
                    Copyright &copy; NeoSon 2019
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Success</h5>
                </div>
                <div class="modal-body">
                    <p>{{ __('A verification link has been sent to your email address.') }}</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    </body>
@endsection

@section('custom_scripts')
    @if (session('resent'))
        <script>
            $(document).ready(function () {
                $('#messageModal').modal({show: true});
            });
        </script>
    @endif
@endsection