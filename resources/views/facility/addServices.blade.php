<meta name="csrf-token" content="{{ csrf_token() }}" />
@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li class="current"><em>Add Services</em></li>
</ul>
@endsection

<form method="post" id="addServices" action="{{url('addServices')}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-4">
                <label>Choose Facility</label>
                <select class="inputField" name="facility_id" id="facility_id" required>
                    <option value="" hidden>Choose Facility</option>
                    @foreach($facility as $facilities)
                    <option value="{{$facilities->service_category_id}}">{{$facilities->official_name}}</option>
                    @endforeach
                </select>
            </div>
            <div id="servicesWrapper" class="col-md-4 d-none">
                <label>Choose Services</label>
                <select class="inputField" name="service_id" id="service_id" required>
                </select>
            </div>
            <div class="col-md-4 hideForm d-none">
                <label>Holidays</label>
                <input type="date" name="holiday" class="inputField" id="datePicker" placeholder="DD-MM-YYY" />
                <i class="fa fa-calendar"
                    style="position:absolute;right:10px;top:10px;pointer-events:none;opacity:6;"></i>
            </div>
            <div class="col-md-8 hideForm d-none">
                <label>Description</label>
                <textarea class="inputField h-auto" rows="5" name="description" placeholder="Description"></textarea>
            </div>
            <div class="col-md-4 hideForm d-none">
                <label>Feature Image</label>
                <input type="file" name="featured_image" class="form-control-file" required />

                <label class="mt-2">Images</label>
                <input type="file" name="images[]" class="form-control-file" multiple />
            </div>
            <div class="col-md-12  hideForm d-none" id="courtsFormWrapper">
                <h4 class="newFormHead"><span>Courts</span></h4>
                <div class="row" id="courtsForm">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <label>Court Name</label>
                            <span class="font10 text-danger d-none" id="courtNameError">Required</span>
                        </div>
                        <input type="text" class="inputField" name="courtName[]" id="courtName" placeholder="Court Name" required />
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <label>Start Time</label>
                            <span class="font10 text-danger d-none" id="startTimeError">Required</span>
                        </div>
                        <input type="time" class="inputField" name="startTime[]" id="startTime" required />
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <label>End Time</label>
                            <span class="font10 text-danger d-none" id="endTimeError">Required</span>
                        </div>
                        <input type="time" class="inputField" name="endTime[]" id="endTime" required />
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <label>Price</label>
                            <span class="font10 text-danger d-none" id="priceError">Required</span>
                        </div>
                        <div class="position-relative">
                            <span class="" style="position: absolute;display: flex;align-items: center;justify-content: center;height: 38px;width: 38px;right: 0;opacity:.6;">₹</span>
                            <input type="text" class="inputField" name="price[]" id="price" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <label>Duration</label>
                            <span class="font10 text-danger d-none" id="durationError">Required</span>
                        </div>
                        <div class="position-relative">
                            <span class="" style="position: absolute;display: flex;align-items: center;justify-content: center;height: 38px;width: 45px;right: 0;opacity:.6;">min</span>
                            <input type="text" class="inputField" name="duration[]" id="duration" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Break Start</label>
                        <input type="time" class="inputField" name="break_start[]" />
                    </div>
                    <div class="col-md-4">
                        <label>Break End</label>
                        <input type="time" class="inputField" name="break_end[]" />
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-flex">
                <div class="hideForm d-none me-3">
                    <button type="button" class="formButton add" id="addMoreCourts">Add Court</button>
                </div>
                <button type="submit" class="formButton submit" name="submit" id="submit_form">Save</button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('assest/js/addService.js')}}"></script>

@endsection