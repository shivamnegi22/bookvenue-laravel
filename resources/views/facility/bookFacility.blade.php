@extends('layouts.aside')
@section('content')

<form method="post" action="#" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-12 m20">
                <h1>Book Facility</h1>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <label>Sports</label>
                        <select class="inputField" name="sports_id">
                            <option value="By the way">Choose Sport</option>
                            @foreach($sports as $sport)
                            <option value="{{$sport->id}}">{{ $sport->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Start Time</label>
                        <input type="time" name="start_time" placeholder="Start Time" class="inputField">
                    </div>
                    <div class="col-md-6">
                        <label>Select Court</label>
                        <select class="inputField" name="sports_id">
                            <option value="By the way">Choose Sport</option>
                            @foreach($sports as $sport)
                            <option value="{{$sport->id}}">{{ $sport->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Date</label>
                        <input type="date" name="date" placeholder="Date" class="inputField">
                    </div>
                    <div class="col-md-6">
                        <label>Duration</label>
                        <div class="qty mt-5">
                            <span class="minus bg-dark">-</span>
                            <input type="number" class="count inputField" name="qty" value="1">
                            <span class="plus bg-dark">+</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="formButton submit" name="submit">Save</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
</form>

@endsection