@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li><a href="#0">Sports Management</a></li>
    <li class="current"><em>Create Services Category</em></li>
</ul>
@endsection

<form method="POST" enctype="multipart/form-data" action="{{ url('sports') }}">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-4">
                <label>Name</label>
                <input type="text" name="name" placeholder="Name" class="inputField" requried>
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
                <textarea name="description" placeholder="Description" class="inputField"></textarea>
            </div>
            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

@endsection