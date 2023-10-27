@extends('layouts.app')

@section('content')

<div class="container loginSection">
    <form class="forms" method="POST" action="{{ route('verify.otp') }}">
        @csrf
        <div class="row">
            <div class="col-md-12 loginHeading">
                <h2>~ Verify OTP to BookVenue ~</h2>
                <sub>Please enter your OTP Number</sub>
            </div>
            <div class="col-md-12">
                <input id="otp" type="text" class="inputField @error('otp') is-invalid @enderror"
                                name="otp" required>
                    @error('otp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
            </div>
            <div class="col-md-12">
                <button type="submit" class="loginButton">Verify OTP&nbsp;<i class="fa-regular fa-circle-check"></i></button>
            </div>
        </div>
    </form>
</div>

@endsection