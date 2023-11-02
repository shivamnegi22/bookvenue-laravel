@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="#0">Service Management</a></li>
    <li><a href="javascript: history.go(-1)">Service</a></li>
    <li class="current"><em>Update Service</em></li>
</ul>
@endsection

<form method="POST" enctype="multipart/form-data" action="{{ url('update-service/'.$service->id) }}">
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
                <input type="text" name="name" placeholder="Name" value="{{$service->name}}" class="inputField" required>
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
                <textarea name="description" placeholder="Description" class="inputField">{{$service->description}}</textarea>
            </div>
            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

@endsection