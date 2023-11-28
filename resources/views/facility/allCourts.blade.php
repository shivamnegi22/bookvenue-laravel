@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Booking Management</a></li>
    <li class="current"><em>All Courts</em></li>
</ul>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-L8F4jde3JF4z8/ZryNB1z4l4iOZWy4btLaaQowjfGMpz8FtfmsudA3LrkUp7viqfJ0p4sCMkHdIJeZlNGp5dJw==" crossorigin="anonymous" />

<style>

button {
  border-radius: 4px;
  background-color: #5ca1e1;
  border: none;
  color: #fff;
  text-align: center;
  font-size: 32px;
  padding: 10px;
  width: 100px;
  transition: all 0.5s;
  cursor: pointer;

  box-shadow: 0 10px 20px -8px rgba(0, 0, 0,.7);
}

button{
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

button:after {
  content:  ''
  opacity: 0;  
  top: 14px;
  right: -20px;
  transition: 0.5s;
}

button:hover{
  padding-right: 24px;
  padding-left:8px;
}

button:hover:after {
  opacity: 1;
  right: 10px;
}
</style>
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
                        <td><a href="{{url('disable-courts/'.$court->court_id)}}"><button class="btn btn-danger">Deactive</button></a></td>
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