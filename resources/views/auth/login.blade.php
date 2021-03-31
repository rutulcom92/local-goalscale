@extends('layouts.auth')

@section('title', 'WMU | Login')

@section('content')
<div class="login_mid">
    @if(!empty(Session::get('error')))
        <div class="alert alert-danger alert-dismissable">
            <a href="javascript:void(0)" class="close" data-dismiss="alert"
               aria-label="close">&times;</a>
            {{ Session::get('error') }}
        </div>
    @endif

    @error('auth.error')
        <div class="alert alert-danger alert-dismissable">
            <a href="javascript:void(0)" class="close" data-dismiss="alert"
               aria-label="close">&times;</a>
            {{ $message }}
        </div>
    @enderror
    <form method="POST" action="{{ route('login') }}" id="login">
        @csrf
        <div class="login_inner">
            <div class="form-group">
                <input type="text" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" placeholder="Password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn_cool">
                    {{ __('Login') }}<i class="far fa-arrow-right"></i>
                </button>
            </div>
            <div class="form-group text-center marzero">
                <a href="{{ route('password.request') }}" class="forgot">Forgot Password</a>
            </div>
        </div>
    </form>
</div>
@endsection
