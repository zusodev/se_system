{{--@extends('layouts.app')--}}
@extends('layouts.old-auth-base')

{{-- TODO remove 1111 --}}
@section('head')
    <meta http-equiv="refresh" content="5;https://www.1111.com.tw"/>
@endsection
@section('content')
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">{{ __('Login') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <div class="form-label-group">
                        <input id="email" name="email" type="email"
                               class="form-control" placeholder="Email address"
                               required autofocus value="">
                        <label for="email">{{ __('E-Mail Address') }}</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input id="password" name="password" type="password"
                               class="form-control"
                               placeholder="Email address" required>
                        <label for="password">{{ __('Password') }}</label>
                    </div>
                </div>
                <button id="login-btn" type="button" class="btn btn-primary btn-block">
                    {{ __('Login') }}
                </button>
            </form>
        </div>
    </div>
    @include("emailLog.error.modal")
@endsection

@section("javascripts")
    <script>
        $(window).on('load',function(){
            $("#error-modal").modal();
        });

    </script>
@endsection
