@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li class="current"><em>Create Facility</em></li>
</ul>
@endsection

<form method="post" action="{{url('createFacility')}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-6 m20">
                <label>Facility Type</label>
                <select class="inputField" name="service_type" required>
                    <option value='' hidden>Select Type</option>
                    @foreach($service_type as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Official Name</label>
                <input type="text" name="name" placeholder="Official Name" class="inputField" required>
            </div>
            <div class="col-md-6">
                <label>Alias</label>
                <input type="text" name="alias" placeholder="Alias" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Amenities</label>
                <!-- <input type="text" name="amenities" placeholder="Amenities" class="inputField"> -->
                <select class="inputField" name="amenities">
                    <option value="AL">Alabama</option>
                    <option value="WY">Wyoming</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Address</label>
                <input type="text" name="address" placeholder="Address" class="inputField" required>
            </div>
            <div class="col-md-6">
                <label>Featured Image</label>
                <input type="file" name="featured_image" placeholder="" class="form-control-file" required>
            </div>
            <div class="col-md-4">
                <label>Latitude</label>
                <input type="text" name="lat" placeholder="Latitude" class="inputField" required>
            </div>
            <div class="col-md-4">
                <label>Longitude</label>
                <input type="text" name="lng" placeholder="Longitude" class="inputField" required>
            </div>
            <div class="col-md-4">
                <button type="button" class="formButton submit w-100 mt-4" data-toggle="modal"
                    data-target="#exampleModalCenter" disabled>
                    Location&nbsp;&nbsp;<i class="fa fa-map-marker"></i></button>
            </div>
            <div class="col-md-12 mb-3">
                <label>Description</label>
                <textarea name="description" placeholder="Description" class="inputField" rows="5"></textarea>
            </div>
            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3">
                    <h5 class="modal-title" id="exampleModalLongTitle">Select Location</h5>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <input type="text" name="address" placeholder="Search Location" class="inputField">
                    </div>
                    <div class="col-md-5">
                        <button type="button" class="formButton submit w-100" data-toggle="modal"
                            data-target="#exampleModalCenter" style="padding:6px 10px">
                            Use Current Location&nbsp;&nbsp;<i class="fa fa-map-marker"></i></button>
                    </div>
                </div>
                <div id="map"></div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="formButton bg-secondary px-5" data-dismiss="modal">Cancel</button>
                    <button type="button" class="formButton submit px-5">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection