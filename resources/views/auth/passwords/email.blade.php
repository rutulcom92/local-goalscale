@extends('layouts.auth')

@section('title','WMU | Reset Password')

@section('content')
<div class="login_mid">
     @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}" id="reset_password_request">
    @csrf
        <div class="login_inner">
            <div class="form-group">
                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> 
            <div class="form-group text-center">
                <button type="submit" class="btn_cool">
                            {{ __('Send Password Reset Link') }} <i class="far fa-arrow-right"></i>
                </button>
            </div> 
            <div class="form-group text-center">
                <a href="{{ route('login') }}" class="backlogin">Back to Login</a>
            </div>
        </div>
    </form>
</div>
@endsection
