@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Booking Management</a></li>
    <li class="current"><em>All Amenities</em></li>
</ul>
@endsection

<div class="tableStyle">
    <div class="row">
        <div class="col-md-12">
            <table id="myTable" class="display table table-bordered responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Sno</th>
                        <th>Name</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($amenity as $item=>$data)
              
                <tr>
                    <td>{{$item + 1}}</td>
                    <td>{{$data->name}}</td>
                    @if($data->status == '1')
                    <td>Active</td>
                    @else
                    <td>Deactive</td>
                    @endif
                    <td><a href="{{url('update-aminity/'.$data->id)}}"><button class="tableButton Update">Edit</button></a>
                        <a href="{{url('delete-aminity/'.$data->id)}}"><button class="tableButton Delete">Delete</button></a></td>
                </tr>
              
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection