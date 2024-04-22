@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li class="current"><em>Deactive Facility</em></li>
</ul>
@endsection

<div class="tableStyle">
    <div class="row">
        <div class="col-md-12">
            <table id="myTable" class="display table table-bordered responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Service Category</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($facility as $data)
                    <tr>
                        <td>@foreach(json_decode($data->service_category_id) as $category_id)
                            <p>{{\App\Models\Service_category::where('id',$category_id)->value('name')}}</p>
                            @endforeach
                        </td>
                        <td>{{$data->official_name}}</td>
                        <td>{{ substr($data->address, 0, 20) }}</td>
                        <td>{{ $data->status }}</td>
                        <td><a href="{{url('update-facility/'.$data->id)}}"><button class="tableButton Update">Edit</button></a>
                        <a href="{{url('delete-facility/'.$data->id)}}"><button class="tableButton Delete">Delete</button></a>
                        <a href="{{url('approved/'.$data->id)}}"><button class="tableButton aproove">Active</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection