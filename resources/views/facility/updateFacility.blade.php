@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li class="current"><em>Update Facility</em></li>
</ul>
@endsection

<form method="post" action="#" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-12 m20">
                <label>Facility Type</label>
                <div class="d-flex justify-content-between">
                    <div>
                        <input type="radio" id="sports" name="facility_type" value="" class="">
                        <label for="html">Sports</label>
                    </div>
                    <div>
                        <input type="radio" id="venue" name="facility_type" value="venue">
                        <label for="css">Venue</label>
                    </div>
                    <div>
                        <input type="radio" id="both" name="facility_type" value="both">
                        <label for="css">Both</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" placeholder="Name" value="{{$facility->official_name}}" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Alias</label>
                <input type="text" name="alias" placeholder="Alias"  class="inputField">
            </div>
            <div class="col-md-4">
                <label>Address</label>
                <input type="text" name="address" placeholder="Address" class="inputField">
            </div>
            <div class="col-md-4">
                <label>Latitude</label>
                <input type="text" name="latitude" placeholder="Latitude" class="inputField">
            </div>
            <div class="col-md-4">
                <label>Longitude</label>
                <input type="text" name="longitude" placeholder="Longitude" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Featured Image</label>
                <input type="file" name="featured_image" placeholder="" class="form-control-file">
            </div>
            <div class="col-md-6">
                <label>Images</label>
                <input type="file" name="images[]" multiple placeholder="" class="form-control-file">
            </div>
            <div class="col-md-12">
                <label>Description</label>
                <textarea type="text" name="description" placeholder="Description" class="inputField"></textarea>
            </div>
            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

@endsection