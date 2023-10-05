@extends('layouts.aside')
@section('content')

<form method="POST" enctype="multipart/form-data" action="{{ url('Venues') }}">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" placeholder="Name" class="inputField">
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