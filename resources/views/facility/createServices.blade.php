@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li><a href="#0">Sports Management</a></li>
    <li class="current"><em>Create Service</em></li>
</ul>
@endsection

<form method="POST" enctype="multipart/form-data" action="{{ url('createServices') }}">
    @csrf
    <div class="container">
        <div class="row form">
        <div class="col-md-6">
                <label>Sevice Category</label>
                <select class="inputField" name="service_category_id" required>
                    <option value="" hidden>Select type</option>
                    @foreach($service_category as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" placeholder="Name" class="inputField" required>
            </div>
            <div class="col-md-6">
                <label>Featured Image</label>
                <input type="file" name="featured_image" placeholder="Featured Image" class="form-control-file" required>
            </div>
            <div class="col-md-6">
                <label>Icon</label>
                <input type="file" name="icon" placeholder="Icon" class="form-control-file" required>
            </div>
            <div class="col-md-12">
                <label>Description</label>
                <textarea name="description" placeholder="Description" class="inputField"></textarea>
            </div>
            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

@endsection