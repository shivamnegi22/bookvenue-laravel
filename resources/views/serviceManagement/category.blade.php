@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="#0">Service Management</a></li>
    <li class="current"><em>Category</em></li>
</ul>
@endsection

<div class="tableStyle">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <a href="servicesCategory" class="linkButton">Create Category</a>
        </div>
        <div class="col-md-12">
            <table id="myTable" class="display table table-bordered responsive nowrap" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category as $data)
                    <tr>
                        <td>{{ $data->name }}</td>
                        @if($data->status == '1')
                        <td>Active</td>
                        @else
                        <td>Deactive</td>
                        @endif
                        <td>{{ $data->description }}</td>
                        <td><a href="{{url('update-service-category/'.$data->id)}}"><button class="btn btn-success">Edit</button></a>
                        <a href="{{url('delete-service-category/'.$data->id)}}"><button class="btn btn-danger">Delete</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection