@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="#0">Configuration</a></li>
    <li class="current"><em>Update Amenities</em></li>
</ul>
@endsection

<form method="POST" enctype="multipart/form-data" action="{{ url('update-amenity/'.$amenity->id) }}">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" placeholder="Name" value="{{$amenity->name}}" class="inputField" required>
            </div>
            <div class="col-md-6">
                <label>Icon</label>
                <input type="file" name="icon" placeholder="Icon"  class="form-control-file" required>
            </div>
            <div class="col-md-12">
                <label>Description</label>
                <textarea name="description" placeholder="Description" class="inputField">{{$amenity->description}}</textarea>
            </div>
            <div class="col-md-12">
                <button type="submit" class="formButton submit" value="submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

@endsection