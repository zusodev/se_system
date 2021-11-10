@extends('layouts.auth-base')
@section('bg') register-half-bg @endsection
@section('content')
    <div class="auth-form-transparent text-left p-3">
        <div class="brand-logo">
            <img src="{{ asset("images/logo.svg") }}" alt="logo">
        </div>
        <h6>重設會員密碼</h6>
        <form class="pt-3" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail">電子郵件</label>
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="email" name="email" class="form-control form-control-lg border-left-0" value="{{ old('email') }}" id="exampleInputEmail" placeholder="E-Mail Address" required autofocus>
                </div>
            </div>
            @error('email')
            <div class="alert alert-fill-danger" role="alert">
                <i class="mdi mdi-alert-circle"></i>
                {{ $message }}
            </div>
            @enderror
            <div class="my-3">
                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">確認送出</button>
            </div>
            <div class="text-center mt-4 font-weight-light">
                想起來密碼?
                <a href="{{ route("login") }}" class="font-weight-normal text-muted">會員登入</a>
            </div>
        </form>
    </div>
@endsection
@section('javascripts')
    <script>
        @error('email')
        $.toast({
            heading: '寄送失敗！',
            text: '{{ $message }}',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
        })
        @enderror
    </script>
@endsection
