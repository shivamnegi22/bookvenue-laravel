@extends('layouts.aside')
@section('content')

<style>
.qty{
    display:flex;
    justify-content:space-between;
    position:relative;
}

.qty .plus{
    position:absolute;
    right:0;
    background-color:cornflowerblue;
    padding:7px 10px;
    color:#fff;
    font-weight:bold;
}
.qty .minus{
    position:absolute;
    left:0;
    background-color:cornflowerblue;
    padding:7px 10px;
    color:#fff;
    font-weight:bold;
}
.qty .inputField{
    padding:0 40px;
}
.formButton{
    width:100%;
    padding:7px;
}
.imgpreview{
    border:1px solid #f2f2f2;
    height:225px;
}
</style>

<form method="post" action="#" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-12 m20">
                <h1>Book Facility</h1>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <label>Sports</label>
                        <select class="inputField" name="sports_id">
                            <option value="By the way">Choose Sport</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Start Time</label>
                        <input type="time" name="start_time" placeholder="Start Time" class="inputField">
                    </div>
                    <div class="col-md-6">
                        <label>Select Court</label>
                        <select class="inputField" name="sports_id">
                            <option value="By the way">Choose Sport</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Date</label>
                        <input type="date" name="date" placeholder="Date" class="inputField">
                    </div>
                    <div class="col-md-6">
                        <label>Duration</label>
                        <div class="qty">
                            <span class="minus">-</span>
                            <input type="number" class="inputField count" name="qty" value="1">
                            <span class="plus">+</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label></label>
                        <button type="submit" class="formButton submit" name="submit">Save</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="imgpreview"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $('.count').prop('disabled', true);
    $(document).on('click', '.plus', function() {
        $('.count').val(parseInt($('.count').val()) + 1);
    });
    $(document).on('click', '.minus', function() {
        $('.count').val(parseInt($('.count').val()) - 1);
        if ($('.count').val() == 0) {
            $('.count').val(1);
        }
    });
});
</script>
@endsection