@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                   <!-- resources/views/auth/login.blade.php -->

<!-- resources/views/auth/verify-otp.blade.php -->

<form method="POST" action="{{ route('verify.otp') }}">
    @csrf

    <!-- OTP Field -->
    <div class="form-group">
        <label for="otp">Enter OTP</label>
        <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" required>
        @error('otp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- Submit button -->
    <button type="submit" class="btn btn-primary">Verify OTP</button>
</form>


                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
