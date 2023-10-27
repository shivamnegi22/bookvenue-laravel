@extends('layouts.app')
@section('content')

<div class="container loginSection">
    <form class="forms" method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="row">
            <div class="col-md-12 loginHeading">
                <h2>~ Login to BookVenue ~</h2>
                <sub>Please enter your mobile number</sub>
            </div>
            <div class="col-md-12">
                <input id="phone" type="text" class="inputField @error('phone') is-invalid @enderror" name="phone"
                    value="{{ old('phone') }}" placeholder="Enter Mobile Number" required autofocus>
                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-md-12">
                <button type="submit" class="loginButton">Send OTP&nbsp;<i class="fa-solid fa-circle-plus"></i></button>
            </div>
            <div class="col-md-12">
                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection