@extends('layouts.auth')

@section('title','WMU | Set Password')

@section('content')
<div class="login_mid">
    <div class="login_inner">
        <form method="POST" action="{{ route('user.password.update') }}" id="set_password">
            @csrf
            <div class="form-group">
                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly="">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn_cool">
                    {{ __('Set Password') }} <i class="far fa-arrow-right"></i>
                </button>
            </div>
            
    </div>
</div>
@endsection
