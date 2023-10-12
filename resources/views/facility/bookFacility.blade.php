@extends('layouts.aside')
@section('content')

<style>
.qty {
    display: flex;
    justify-content: space-between;
    position: relative;
}

.qty .plus {
    position: absolute;
    right: 0;
    background-color: cornflowerblue;
    padding: 7px 10px;
    color: #fff;
    font-weight: bold;
}

.qty .minus {
    position: absolute;
    left: 0;
    background-color: cornflowerblue;
    padding: 7px 10px;
    color: #fff;
    font-weight: bold;
}

.qty .inputField {
    padding: 0 40px;
}

.imgpreview {
    border: 1px solid #f2f2f2;
    height: 225px;
}

.imgpreview img {
    width: 100%;
    height: 225px;
}
</style>

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Booking Management</a></li>
    <li><a href="#0">Booking</a></li>
    <li class="current"><em>Create Booking</em></li>
</ul>
@endsection

<form method="post" action="{{url('/book-facility')}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <label>Facility</label>
                        <select class="inputField" name="facility_id" id="facilitySelect">
                            <option value="">Choose Facility</option>
                            @foreach($facility as $facilities)
                            <option value="{{$facilities->id}}">{{$facilities->official_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Facility Type</label>
                        <select class="inputField" name="facility_type" id="facilityTypeSelect">
                            <option value="">Choose facility type</option>
                            <option value="Venue">Venue</option>
                            <option value="Sport">Sport</option>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Sports</label>
                        <select class="inputField" name="sports" id="sports" disabled>
                            <option value="">Choose Sport</option>
                            @foreach($sport as $sports)
                            <option value="{{$sports->id}}">{{$sports->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Venue</label>
                        <select class="inputField" name="venues" id="venue" disabled>
                            <option value="">Choose Venue</option>
                            @foreach($venue as $venues)
                            <option value="{{$venues->id}}">{{$venues->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label>Select Court</label>
                        <select class="inputField" name="sports_court_id" id="court" disabled>
                            <option value="By the way">Choose Court</option>
                            <option value="1">1</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Start Time</label>
                        <input type="time" name="start_time" placeholder="Start Time" class="inputField">
                    </div>

                    <div class="col-md-6">
                        <label>Date</label>
                        <input type="date" name="date" placeholder="Date" class="inputField">
                    </div>
                    <div class="col-md-6">
                        <label>Duration</label>
                        <div class="qty">
                            <span class="minus">-</span>
                            <input type="text" class="inputField count" name="duration" value="0">
                            <span class="plus">+</span>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <button type="submit" class="formButton submit" name="submit">Save</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="imgpreview">
                            <img src="{{asset('image/booking.jpg')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    $('#facilitySelect').on('change', function() {
        var facilityId = $('#facilitySelect').val();

        $.ajax({
            url: '/facility-image/' + facilityId,
            method: 'GET',
            success: function(response) {

                var imageUrl = response;
                var img = $('<img>').attr('src', imageUrl);

                // Append the img element to the imgpreview div
                $('.imgpreview').empty().append(img);

            },
            error: function(error) {
                console.error('AJAX Error:', error);
            }
        });
    });


    $('#sports').on('change', function() {
        var facilityId = $('#facilitySelect').val();
        var sport_id = $('#sports').val();

        $.ajax({
            url: '/sport-court/' + facilityId + '/' + sport_id,
            method: 'GET',
            success: function(response) {

                var courtSelect = $('#court');

                // Clear any existing options
                courtSelect.empty();

                // Add a default "Choose Court" option
                courtSelect.append($('<option>', {
                    value: '',
                    text: 'Choose Court'
                }));

                // Loop through the response data and add options to the select element
                $.each(response, function(index, court) {
                    courtSelect.append($('<option>', {
                        value: court.id,
                        text: court.name
                    }));
                });

                // Enable the court select element
                courtSelect.prop('disabled', false);
            },
            error: function(error) {
                console.error('AJAX Error:', error);
            }
        });
    });
});
</script>


<script>
// Get references to the select elements
const facilityTypeSelect = document.getElementById('facilityTypeSelect');
const sportsSelect = document.getElementById('sports');
const venueSelect = document.getElementById('venue');
const courtSelect = document.getElementById('court');

// Add an event listener to the facility_type select element
facilityTypeSelect.addEventListener('change', function() {
    // Disable all select elements initially
    sportsSelect.disabled = true;
    venueSelect.disabled = true;
    courtSelect.disabled = true;

    // Enable the select element based on the selected option
    if (facilityTypeSelect.value === 'Venue') {
        venueSelect.disabled = false;
    } else if (facilityTypeSelect.value === 'Sport') {
        sportsSelect.disabled = false;
        courtSelect.disabled = false;
    }
});
</script>

<script>
$(document).ready(function() {
    // Initialize the initial value as a number
    var countInput = $('.count');
    var initialValue = parseInt(countInput.val());

    // Handle the minus button click
    $('.minus').click(function() {
        if (initialValue > 0) {
            initialValue--;
            countInput.val(initialValue);
        }
    });

    // Handle the plus button click
    $('.plus').click(function() {
        initialValue++;
        countInput.val(initialValue);
    });

    // You can also handle input changes manually if needed
    countInput.change(function() {
        var newValue = parseInt(countInput.val());
        if (!isNaN(newValue)) {
            initialValue = newValue;
        }
    });
});
</script>


@endsection