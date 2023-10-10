@extends('layouts.aside')
@section('content')

<form method="POST" enctype="multipart/form-data" action="{{ url('Venues') }}">
    @csrf
    <div class="container">
        <div class="row form">
        <div class="col-md-12 m20"><h1>Create Venues</h1></div>
            <div class="col-md-4">
                <label>Name</label>
                <input type="text" name="name" placeholder="Name" class="inputField">
            </div>
            <div class="col-md-4">
                <label>Featured Image</label>
                <input type="file" name="featured_image" placeholder="Featured Image" class="form-control-file">
            </div>
            <div class="col-md-4">
                <label>Icon</label>
                <input type="file" name="icon" placeholder="Icon" class="form-control-file">
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