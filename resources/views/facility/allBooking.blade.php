@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li class="current"><em>All Facility</em></li>
</ul>
@endsection

<div class="tableStyle">
    <div class="row">
        <div class="col-md-12">
            <table id="myTable" class="display table table-bordered responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Facility</th>
                        <th>Facility Type</th>
                        <th>Sport</th>
                        <th>Court</th>
                        <th>Start Time</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking as $data)
                    <tr>
                        <td>{{\App\Models\Profile::where('user_id',$data->user_id)->value('name')}}</td>
                        <td>{{\App\Models\facility::where('id',$data->facility_id)->value('official_name')}}</td>
                        <td>{{$data->facility_type}}</td>
                        <td>{{\App\Models\sports::where('id',$data->sport_id)->value('name')}}</td>
                        <td>{{\App\Models\facility_sports_court::where('id',$data->sport_court_id)->value('name')}}</td>
                        <td>{{$data->start_time}}</td>
                        <td>{{$data->date}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection