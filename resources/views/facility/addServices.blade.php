@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Service Management</a></li>
    <li class="current"><em>Category</em></li>
</ul>
@endsection

<form method="post" action="{{url('#')}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-6">
                <label>Choose Facility</label>
                <select class="inputField" name="facility_id" id="facilitySelect">
                    <option value="" hidden>Choose Facility</option>
                    <option value="Venue">Venue</option>
                    <option value="Sport">Sport</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Choose Service</label>
                <select class="inputField" name="services_category_id" id="services_type">
                    <option value="" hidden>Choose Service</option>
                    <option value="Venue">Venue</option>
                    <option value="Sport">Sport</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Feature Image</label>
                <input type="file" name="" class="form-control-file">
            </div>
            <div class="col-md-4">
                <label>Images</label>
                <input type="file" name="" class="form-control-file" multiple>
            </div>
            <div class="col-md-4">
                <label>Holiday</label>
                <input type="text" name="" class="inputField">
            </div>
            <div class="col-md-12">
                <label>Description</label>
                <textarea class="inputField" rows="5" name="description" placeholder="Description"></textarea>
            </label>
            <div class="col-md-12"></div>
            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

@endsection