@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="#0">Service Management</a></li>
    <li><a href="javascript: history.go(-1)">Category</a></li>
    <li class="current"><em>Update Services Category</em></li>
</ul>
@endsection

<form method="POST" enctype="multipart/form-data" action="{{ url('update-service-category/'.$category->id) }}">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-4">
                <label>Name</label>
                <input type="text" name="name" placeholder="Name" class="inputField" value="{{$category->name}}" requried>
            </div>
            <div class="col-md-4">
                <label>Featured Image</label>
                <input type="file" name="featured_image" placeholder="Featured Image" class="form-control-file">
            </div>
            <div class="col-md-4">
                <label>Icon</label>
                <input type="file" name="icon" placeholder="Icon" class="form-control-file">
            </div>
            <div class="col-md-12 mb-3">
                <label>Description</label>
                <textarea name="description" placeholder="Description" class="inputField">{{$category->description}}</textarea>
            </div>
            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Update</button>
            </div>
        </div>
    </div>
</form>

@endsection