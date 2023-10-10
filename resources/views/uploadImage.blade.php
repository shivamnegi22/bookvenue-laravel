@extends('layouts.aside')
@section('content')

<form method="post" action="{{url('uploads')}}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="images[]" multiple>

    <button type ="submit" name="submit" value="submit">submit</button>
</form>
@endsection