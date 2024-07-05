@extends('layouts.app')

@section('content')
<div class="auth-content">
    <h2 class="form-title">Login</h2>
    <form method="POST" action="{{ route('login') }}" class="register-form" id="login-form">
        @csrf
        <div class="form-group">
            <label for="email"><i class="zmdi zmdi-email"></i></label>
            <input type="email" name="email" id="email" placeholder="Your Email" value="{{ old('email') }}" required autocomplete="email" autofocus class="@error('email') is-invalid @enderror"/>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password"><i class="zmdi zmdi-lock"></i></label>
            <input type="password" name="password" id="password" placeholder="Password" required autocomplete="current-password" class="@error('password') is-invalid @enderror"/>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <label for="remember" class="label-agree-term">Remember Me</label>
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="agree-term"/>
                </div>
                @if (Route::has('password.request'))
                    <a class="btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
        <div class="form-group form-button">
            <button type="submit" name="login" id="login" class="form-submit">
                {{ __('Login') }}
            </button>
        </div>
    </form>
</div>
@endsection
