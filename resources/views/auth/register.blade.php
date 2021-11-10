@extends('layouts.auth-base')
@section('bg') register-half-bg @endsection
@section('content')
    <div class="auth-form-transparent text-left p-3">
        <div class="brand-logo">
            <img src="{{ asset("images/logo.svg") }}" alt="logo">
        </div>
        <h6>會員註冊</h6>

        <form class="pt-3" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail">會員名稱</label>
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" name="name" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="Username" value="{{ old('name') }}" autofocus>
                </div>
            </div>
            @error('name')
            <div class="alert alert-fill-danger" role="alert">
                <i class="mdi mdi-alert-circle"></i>
                {{ $message }}
            </div>
            @enderror

            <div class="form-group">
                <label for="exampleInputEmail">電子郵件</label>
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                          <i class="mdi mdi-email-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="email" name="email" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="E-Mail Address" value="{{ old('email') }}">
                </div>
            </div>
            @error('email')
            <div class="alert alert-fill-danger" role="alert">
                <i class="mdi mdi-alert-circle"></i>
                {{ $message }}
            </div>
            @enderror

            <div class="form-group">
                <label for="exampleInputPassword">會員密碼</label>
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" name="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Password">
                </div>
            </div>
            @error('password')
            <div class="alert alert-fill-danger" role="alert">
                <i class="mdi mdi-alert-circle"></i>
                {{ $message }}
            </div>
            @enderror

            <div class="form-group">
                <label for="exampleInputPassword">確認密碼</label>
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" name="password_confirmation" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Confirm Password">
                </div>
            </div>

            <div class="my-3">
                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">註冊會員</button>
            </div>
            <div class="text-center mt-4 font-weight-light">
                已註冊會員?
                <a href="{{ route("login") }}" class="font-weight-normal text-muted">會員登入</a>
            </div>
        </form>
    </div>
@endsection
@section('javascripts')
    <script>
        @error('name')
        $.toast({
            heading: '註冊失敗！',
            text: '{{ $message }}',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
        })
        @enderror
        @error('password')
        $.toast({
            heading: '註冊失敗！',
            text: '{{ $message }}',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
        })
        @enderror
        @error('email')
        $.toast({
            heading: '註冊失敗！',
            text: '{{ $message }}',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
        })
        @enderror
    </script>
@endsection
