@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li class="current"><em>Add Services</em></li>
</ul>
@endsection

<form method="post" action="{{url('addServices')}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
        <div class="col-md-4">
                <label>Choose Facility</label>
                <select class="inputField" name="facility_id" id="facility_id" required>
                    <option value="" hidden>Choose Facility</option>
                    @foreach($facility as $facilities)
                    <option value="{{$facilities->id}}">{{$facilities->official_name}}</option>
                  @endforeach
                </select>
                <span id="facility_message" style="color:red;display:none;">required</span>
            </div>
            <div class="col-md-4">
                <label>Choose Service Category</label>
                <select class="inputField" name="service_category_id" id="service_category_id" disabled required>
                    <option value="" hidden>Choose Service Category</option>
                </select>
                <span id="category_message" style="color:red;display:none;">required</span>
            </div>
            <div class="col-md-4">
                <label>Choose Service</label>
                <select class="inputField" name="services_id" id="service_id" disabled required>
                    <option value="" hidden>Choose Service</option>
                </select>
                <span id="service_message" style="color:red;display:none;">required</span>
            </div>
            <div class="col-md-4">
                <label>Feature Image</label>
                <input type="file" name="featured_image" class="form-control-file">
            </div>
            <div class="col-md-4">
                <label>Images</label>
                <input type="file" name="images[]" class="form-control-file" multiple>
            </div>
            <div class="col-md-4">
                <label>Holidays</label>
                <input type="date" name="holiday" class="inputField">
            </div>
            <div class="col-md-12">
                <label>Description</label>
                <textarea class="inputField" rows="5" name="description" placeholder="Description"></textarea>
            </div>
            <div class="col-md-12 mb-3">
                <button type="button" class="formButton add" id="addForm">Add Court</button>
            </div>

            <div class="col-md-12" id="formsContainer"></div>
            <div class="col-md-12">
                <button type="button" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('assest/js/addService.js')}}"></script>
@endsection