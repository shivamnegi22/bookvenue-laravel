@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card"
                style="background: linear-gradient(180deg, #DCF9E0 0%, #FFFFFF 30.21%);box-shadow: 0px 187px 75px rgba(0, 0, 0, 0.01), 0px 105px 63px rgba(0, 0, 0, 0.05), 0px 47px 47px rgba(0, 0, 0, 0.09), 0px 12px 26px rgba(0, 0, 0, 0.1), 0px 0px 0px rgba(0, 0, 0, 0.1);border-radius: 16px;border:none;">
                <div class="card-header"
                    style="border-bottom:none;font-weight: 700;font-size: 17px;line-height: 21px;text-align: center;color: #2B2B2F;margin-bottom: 15px;">
                    {{ __('Login') }}</div>
                <div class="card-body">
                    <!-- resources/views/auth/login.blade.php -->
                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <!-- Phone Number Field -->
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') }}" required autofocus>
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="row mb-3 mt-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    Send OTP
                                </button>
                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}"
                                    style="font-size: 14px;text-decoration:none;margin-left: 5px;color: #2d79f3;font-weight: 500;cursor: pointer;">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="container loginSection">
    <form class="forms">
        <div class="row">
            <div class="col-md-12 loginHeading">
                <h2>~ Login to BookVenue ~</h2>
                <sub>Please enter your mobile number</sub>
            </div>
            <div class="col-md-12">
                <input type="text" class="inputField" placeholder="Enter Mobile Number">
            </div>
            <div class="col-md-12">
                <button class="loginButton">Send OTP&nbsp;<i class="fa-solid fa-circle-plus"></i></button>
            </div>
        </div>
    </form>
</div> -->
@endsection
