@extends('layouts.app')
@section('content')

<div class="container loginSection">
    <form class="forms" method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="row">
            <div class="col-md-12 loginHeading">
                <h2>~ Login to BookVenue ~</h2>
                <sub>Please enter your mobile number and password</sub>
            </div>
            <div class="col-md-12">
                <input id="phone" type="text" class="inputField @error('phone') is-invalid @enderror" name="phone" onkeypress='validate(event)'
                    value="{{ old('phone') }}" placeholder="Enter Mobile Number" autocomplete="off" required autofocus>
                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-md-12">
                <input id="password" type="password" class="inputField @error('password') is-invalid @enderror" name="password"
                    value="{{ old('password') }}" placeholder="Enter Password" required autofocus>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-md-12">
                <button type="submit" class="loginButton">Log in&nbsp;<i class="fa-solid fa-circle-plus"></i></button>
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