@extends('layouts.app')

@section('content')
<div class="auth-content">
    <h2 class="form-title">Register</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name" class="zmdi zmdi-account material-icons-name"></label>
            <input id="name" type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required autocomplete="name" autofocus class="@error('name') is-invalid @enderror"/>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email" class="zmdi zmdi-email"></label>
            <input id="email" type="email" name="email" placeholder="Your Email" value="{{ old('email') }}" required autocomplete="email" class="@error('email') is-invalid @enderror"/>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="zmdi zmdi-lock"></label>
            <input id="password" type="password" name="password" placeholder="Password" required autocomplete="new-password" class="@error('password') is-invalid @enderror"/>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password-confirm" class="zmdi zmdi-lock-outline"></label>
            <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password"/>
        </div>
        <div class="form-group form-button">
            <button type="submit" class="form-submit">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>
@endsection
