<template>
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">{{ __('Login') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <div class="form-label-group">
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email address"
                               required autofocus value="{{ old('email') }}">
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        {{--@error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror--}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input id="password" name="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" required>
                        <label for="password">{{ __('Password') }}</label>
                    </div>
                    {{--@error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror--}}
                </div>
                {{--<div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>--}}


                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="remember-me">
                            Remember Password
                        </label>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-block">
                    {{ __('Login') }}
                </button>
            </form>
            <div class="text-center">
                @if (Route::has('password.request'))
                <a class="d-block small" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
