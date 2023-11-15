@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Booking Management</a></li>
    <li><a href="#0">Booking</a></li>
    <li class="current"><em>All Booking</em></li>
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
                        <td>{{\App\Models\Service_category::where('id',$data->service_category_id)->value('name')}}</td>
                        <td>{{$data->official_name}}</td>
                        <td>{{ substr($data->address, 0, 20) }}</td>
                        @if($data->status == '1')
                        <td>Active</td>
                        @else
                        <td>Deactive</td>
                        @endif
                        <td><a href="{{url('update-facility/'.$data->id)}}"><button class="tableButton Update">Edit</button></a>
                        <a href="{{url('delete-facility/'.$data->id)}}"><button class="tableButton Delete">Delete</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection