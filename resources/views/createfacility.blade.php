@extends('layouts.aside')
@section('content')
<form method="post" action="{{url('createFacility')}}" enctype="multipart/form-data">
    @csrf
    <input type="radio" id="sports" name="facility_type" value="sports">
    <label for="html">sports</label><br>
    <input type="radio" id="venue" name="facility_type" value="venue">
    <label for="css">venue</label><br>
    <input type="text" name="name" placeholder="name"><br>
    <input type="text" name="alias" placeholder="alias"><br>
    <input type="text" name="address" placeholder="address"><br>
    <input type="text" name="location" placeholder="location"><br>
    <input type="file" name="featured_image" placeholder=""><br>
    <input type="file" name="images[]" multiple placeholder=""><br>
    <input type="time" name="time[start]" placeholder="time"><br>
    <input type="time" name="time[end]" placeholder="time"><br>
    <input type="text" name="description" placeholder="description"><br>
    <button type= "submit" class="btn btn-info" name="submit">Save</button>
</form>
@endsection