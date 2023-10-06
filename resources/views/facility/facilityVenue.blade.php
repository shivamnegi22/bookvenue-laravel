@extends('layouts.aside')
@section('content')

<form method="POST" enctype="multipart/form-data" action="{{ url('venue-facility') }}">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-6">
                <label>Facility</label>
                <select class="inputField" name="facility_id">
                <option value="By the way">Choose Facility</option>
                    @foreach($facility as $data)
                    <option value="{{ $data->id }}">{{ $data->official_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Venue</label>
                <select class="inputField" name="venue_id">
                <option value="">Choose Venue</option>
                @foreach($venues as $venue)
                    <option value="{{$venue->id}}">{{ $venue->name }}</option>
                @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Amenities</label>
                <input type="text" name="amenities" placeholder="Amenities" class="inputField">
            </div>
            <div class="col-md-4">
                <label>Start Time</label>
                <input type="time" name="start_time" placeholder="Start Time" class="inputField">
            </div>
            <div class="col-md-4">
                <label>Close Time</label>
                <input type="time" name="close_time" placeholder="Close Time" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Slot Time</label>
                <input type="text" name="slot_price" placeholder="slot_time" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Slot Price</label>
                <input type="text" name="slot_time" placeholder="slot price" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Court Count</label>
                <input type="text" name="court_count" placeholder="court count" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Breaktime Start</label>
                <input type="time" name="breaktime_start" placeholder="breaktime start" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Breaktime End</label>
                <input type="time" name="breaktime_end" placeholder="breaktime end" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Holiday</label>
                <input type="text" name="holiday[]" placeholder="slot_time" class="form-control-file">
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