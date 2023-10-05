@extends('layouts.aside')
@section('content')

<form method="post" action="{{url('#')}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-6">
                <label>Facility</label>
                <select class="inputField">
                    <option value="By the way">BTW</option>
                    <option value="Talk to you later">TTYL</option>
                    <option value="To be honest">TBH</option>
                    <option value=" I don’t know">IDK</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Sport</label>
                <select class="inputField">
                    <option value="By the way">BTW</option>
                    <option value="Talk to you later">TTYL</option>
                    <option value="To be honest">TBH</option>
                    <option value=" I don’t know">IDK</option>
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
                <label>Location</label>
                <input type="text" name="location" placeholder="Location" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Slot Time</label>
                <input type="time" name="slot_time" placeholder="slot_time" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Status</label>
                <select class="inputField">
                    <option value="By the way">BTW</option>
                    <option value="Talk to you later">TTYL</option>
                    <option value="To be honest">TBH</option>
                    <option value=" I don’t know">IDK</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Holiday</label>
                <input type="file" name="slot_time" placeholder="slot_time" class="form-control-file">
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