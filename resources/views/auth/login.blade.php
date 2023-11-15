@extends('layouts.app')
@section('content')

<div class="container login_page">
    <form class="forms" method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="d-flex flex row g-0">
            <div class="col-md-6 mt-3">
                <div class="card card2">
                    <img src="image/favicon.png" height="100" width="100" />
                    <div class="image">
                        <img src="image/Bookvenue-text.png">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="card card1">
                    <div class="d-flex flex-column"> <span class="login">~ Login to BookVenue ~</span> </div>
                    <div class="input-field d-flex flex-column mt-3">
                        <span>Mobile Number</span>
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" 
                onkeypress='validate(event)' value="{{ old('phone') }}" placeholder="Enter Mobile Number" autocomplete="off" required autofocus>
                        <span class="mt-3">Password</span>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Enter Your Password" autofocus>
                        <button type="submit" class="mt-4 login_btn d-flex justify-content-center align-items-center">Login</button>
                        <div class="mt-3 text1">
                            @if (Route::has('password.request'))
                            <a class="forget" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function validate(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>
@endsection