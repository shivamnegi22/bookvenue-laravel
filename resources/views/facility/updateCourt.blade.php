<meta name="csrf-token" content="{{ csrf_token() }}" />
@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li class="current"><em>Update Services</em></li>
</ul>
@endsection

<form method="post" id="addServices" action="{{url('update-courts/'.$court->id)}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">

            <div class="col-md-12 " id="courtsFormWrapper">
                <h4 class="newFormHead"><span>Courts</span></h4>
                <div class="row courtsForm" id="courtsForm">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <label>Court Name</label>
                        </div>
                        <input type="text" class="inputField" name="courtName" id="courtName" value="{{$court->court_name}}"  placeholder="Court Name" required />
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <label>Start Time</label>
                        </div>
                        <input type="time" class="inputField" name="startTime" id="startTime" value="{{$court->start_time}}" required />
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <label>End Time</label>
                        </div>
                        <input type="time" class="inputField" name="endTime" id="endTime"  value="{{$court->end_time}}" required/>
                    </div>
                    <div class="col-md-4">
                        <label>Description</label>
                        <textarea class="inputField h-auto" rows="5" name="court_description" placeholder="description">{{$court->description}}</textarea>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <label>Price</label>
                                  
                                </div>
                                <input type="number" class="inputField" value="{{$court->slot_price}}" name="price" id="price" required/>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <label>Duration</label>
                                
                                </div>
                                <input type="number" class="inputField" name="duration" value="{{$court->duration}}" id="duration" required/>
                            </div>

                            <div class="col-md-12" id="addBreakFormWrapper">
                            <div class="row addBreakForm" id="addBreakForm">
                                
                            <div class="col-md-5">
                                <label>Break Start</label>
                                <input type="time" class="inputField breakStart" id="breakStart" name="break_start[0]" />
                            </div>
                            <div class="col-md-5">
                                <label>Break End</label>
                                <input type="time" class="inputField breakEnd" id="breakEnd" name="break_end[0]" />
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-success" id="addBreaks">Add</button>
                            </div>
                            </div>
                            @foreach(json_decode($court->breaks, true) as $key=> $break)
                            <div class="row addBreakForm" id="{{$key + 1}}updateBreak">
                            <div class="col-md-5">
                                <label>Break Start</label>
                                <input type="time" class="inputField breakStart" value="{{$break['start_time']}}" name="break_start[{{$key + 1}}]" readonly/>
                            </div>
                            <div class="col-md-5">
                                <label>Break End</label>
                                <input type="time" class="inputField breakEnd" value="{{$break['end_time']}}" name="break_end[{{$key + 1}}]"  readonly/>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-danger"  onclick="removeBreak('{{$key + 1}}updateBreak')">Remove</button>
                            </div>  
                            </div>
                            @endforeach
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                    <button type="submit" class="formButton submit" name="submit" value="submit" id="submit_form">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('assest/js/addService.js')}}" defer></script>



@endsection