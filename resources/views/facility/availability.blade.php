@extends('layouts.aside')

@section('head')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li class="current"><em>Create Facility</em></li>
</ul>
@endsection

@section('content')
<form method="post" action="{{url('availability')}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-6">
                <label>Facility Name</label>
                <select class="inputField" name="facility" id="facility_name" required>
                    <option value=''>Select Facility</option>
                  @foreach($facility as $data)
                  <option value='{{$data->id}}'>{{$data->official_name}}</option>
                  @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label>Court</label>
                <select class="inputField" name="court" id="court" required>
                    <option value=''>Select Court</option>
                </select>
            </div>

            <div class="col-md-6">
                <label>Start Date</label>
                <input type="date" name="start_date"  class="inputField" required>
            </div>

            <div class="col-md-6">
                <label>End Date</label>
                <input type="date" name="end_date"  class="inputField" required>
            </div>

            <div class="col-md-6">
                <label>Slots</label>
                <select class="inputField" name="slots" id="slots" required>
                <option value=''>Select Slots</option>
                </select>
            </div>


            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $(document).on('change', '#facility_name', function() {
    var facility_id = $(this).val();
    
    $.ajax({
        url: "/get-courts/" + facility_id,
        type: "GET",
        success: function(data) {
            var options = '<option value="">Choose Court</option>';
            $.each(data, function(index, value) {
              options += '<option value="' + value.id + '">' + value.court_name + '</option>';
            });
            $('#court').html(options);

            
        },
        error: function(jqXHR, textStatus, errorThrown) {
          
        }
    });
});

$(document).on('change', '#court', function() {
        var courtId = $(this).val();

        if (!courtId) {
            $('#slots').html('<option value="">Select Slots</option>');
            return;
        }

        $.ajax({
            url: "/get-courts/" + $('#facility_name').val(),
            type: "GET",
            success: function(data) {
                var selectedCourt = data.find(court => court.id == courtId);
                var slotOptions = '<option value="">Select Slots</option>';
                if (selectedCourt && selectedCourt.slots) {
                    $.each(selectedCourt.slots, function(index, slot) {
                        slotOptions += '<option value="' + slot + '">' + slot + '</option>';
                    });
                }
                $('#slots').html(slotOptions);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error fetching slots:", errorThrown);
            }
        });
    });
});
</script>

@endsection