@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Files Upload</a></li>
    <li class="current"><em>Images Upload</em></li>
</ul>
@endsection

<form method="post" action="{{url('uploads')}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
        <div class="col-md-12 m20"><h1>Upload Images</h1></div>
            <div class="col-md-4">
                <label>Upload Images</label>
                <input type="file" name="images[]" class="form-control-file" multiple>
            </div>
            <div class="col-md-8">
                <button class="formButton submit" type="submit" name="submit" value="submit">Submit</button>
            </div>
        </div>
    </div>
</form>
@endsection