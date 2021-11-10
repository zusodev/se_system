@extends('layouts.auth-base')
@section('bg') login-half-bg @endsection
@section('content')
    <div class="auth-form-transparent text-left p-3">
        <div class="brand-logo">
            <img src="{{ asset("images/logo.svg") }}" alt="logo">
        </div>
        <form class="pt-3" method="POST" action="{{ route('login') }}">
            @csrf
            @error('email')
            <div class="alert alert-fill-danger" role="alert">
                <i class="mdi mdi-alert-circle"></i>
                {{ $message }}
            </div>
            @enderror

            <div class="form-group">
                <label for="email">會員帳號</label>
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input id="email" name="email" type="email"
                           class="form-control form-control-lg border-left-0"
                           placeholder="Username"
                           value="">
                </div>
            </div>
            <div class="form-group">
                <label for="password">會員密碼</label>
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input id="password" name="password" type="password"
                           class="form-control form-control-lg border-left-0"
                           placeholder="Password" value="">
                </div>
            </div>
            @error('password')
            <div class="alert alert-fill-danger" role="alert">
                <i class="mdi mdi-alert-circle"></i>
                {{ $message }}
            </div>
            @enderror
            <div class="my-2 d-flex justify-content-between align-items-center">

                {{--<div class="form-check">
                    <label class="form-check-label text-muted">
                        <input class="form-check-input" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                        保持登入狀態
                        <i class="input-helper"></i></label>
                </div>--}}
                {{--<a href="{{ route('password.request') }}" class="text-muted font-weight-normal">忘記密碼?</a>--}}
            </div>
            <div class="my-3">
                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">會員登入
                </button>
            </div>
            {{--<div class="text-center mt-4 font-weight-light">
                尚未註冊會員?
                <a href="{{ route('register') }}" class="font-weight-normal text-muted">建立會員</a>
            </div>--}}
        </form>
    </div>
@endsection
@section('javascripts')
    <script>
        @error('password')
        $.toast({
            heading: '登入失敗！',
            text: '{{ $message }}',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
        })
        $.toast({
            heading: '登入失敗！',
            text: '{{ $message }}',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
        })
        @enderror
    </script>
@endsection
