@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li class="current"><em>All Courts</em></li>
</ul>
@endsection

<div class="tableStyle">
    <div class="row">
        <div class="col-md-12">
            <table id="myTable" class="display table table-bordered responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Facility</th>
                        <th>Service</th>
                        <th>court</th>
                        <th>Start/End Time</th>
                        <th>Duration</th>
                        <th>Slot Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                  
                <tbody>
                    @foreach($courtData as $court)
                    
                    <tr>
                        <td>{{$court->facility_name}}</td>
                        <td>{{$court->service_name}}</td>
                        <td>{{$court->court}}</td>
                        <td>{{$court->start_time}} to {{$court->end_time}}</td>
                        <td>{{$court->duration}}</td>
                        <td>{{$court->price}}</td>

                        <td><a href="{{url('update-courts/'.$court->court_id)}}"><button class="tableButton Update">Edit</button></a>
                        <a href="{{url('disable-courts/'.$court->court_id)}}"><button class="tableButton Delete">Delete</button></a></td>
                    </tr>
                   
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
</script>
@endsection