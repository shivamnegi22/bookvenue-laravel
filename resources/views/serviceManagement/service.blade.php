@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="/dashboard">Dashboard</a></li>
    <li><a href="#0">Service Management</a></li>
    <li class="current"><em>Service</em></li>
</ul>
@endsection

<div class="tableStyle">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <a href="createServices" class="linkButton">Create Services</a>
        </div>
        <div class="col-md-12">
            <table id="myTable" class="display table table-bordered responsive nowrap" cellspacing="0">
                <thead>
                    <tr>
                        <th>Service Category</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($service as $data)
                    <tr>
                    <td>{{\App\Models\Service_category::where('id',$data->service_category_id)->value('name')}}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ substr($data->description, 0, 20) }}</td>
                        @if($data->status == '1')
                        <td>Active</td>
                        @else
                        <td>Deactive</td>
                        @endif
                        <td><a href="{{url('update-service/'.$data->id)}}"><button class="btn btn-success">Edit</button></a>
                        <a href="{{url('delete-service/'.$data->id)}}"><button class="btn btn-danger">Delete</button></a></td>
                    </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection