@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="background: linear-gradient(180deg, #DCF9E0 0%, #FFFFFF 30.21%);box-shadow: 0px 187px 75px rgba(0, 0, 0, 0.01), 0px 105px 63px rgba(0, 0, 0, 0.05), 0px 47px 47px rgba(0, 0, 0, 0.09), 0px 12px 26px rgba(0, 0, 0, 0.1), 0px 0px 0px rgba(0, 0, 0, 0.1);border-radius: 16px;border:none;">
                <div class="card-header" style="border-bottom:none;font-weight: 700;font-size: 17px;line-height: 21px;text-align: center;color: #2B2B2F;margin-bottom: 15px;">{{ __('Login') }}</div>

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
    <button type="submit" class="btn btn-primary mt-3">Verify OTP</button>
</form>


                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
