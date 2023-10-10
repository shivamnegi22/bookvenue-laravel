@extends('layouts.aside')
@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ url('sports-facility') }}">
    @csrf
    <div class="container">
        <div class="row form">
        <div class="col-md-12 m20"><h1>Create Facility Sport</h1></div>
            <div class="col-md-6">
                <label>Facility</label>
                <select class="inputField" name="facility_id">
                    <option value="By the way">Choose Facility</option>
                    @foreach($facility as $data)
                    <option value="{{ $data->id }}">{{ $data->official_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Sport</label>
                <select class="inputField" name="sports_id">
                    <option value="By the way">Choose Sport</option>
                    @foreach($sports as $sport)
                    <option value="{{$sport->id}}">{{ $sport->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Amenities</label>
                <input type="text" name="amenities" placeholder="Amenities" class="inputField">
            </div>
            <div class="col-md-4">
                <label>Start Time</label>
                <input type="time" name="start_time" placeholder="Start Time" class="inputField">
            </div>
            <div class="col-md-4">
                <label>Close Time</label>
                <input type="time" name="close_time" placeholder="Close Time" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Slot Time</label>
                <input type="text" name="slot_time" placeholder="Slot Time" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Holiday</label>
                <input type="text" name="holiday[]" placeholder="Holiday" class="inputField">
            </div>
            <div class="col-md-12">
                <label>Description</label>
                <textarea type="text" name="description" placeholder="Description" class="inputField"></textarea>
            </div>
            <div class="col-md-12 mb-3">
                <span id="addAccordionItem" class="formButton add" onclick="addSportsCourt()">Add Sports Court</span>
            </div>
            <div class="col-md-12">
                <div class="accordion" id="accordionExample">
                </div>
                <div id="formContainer">

            </div>
            </div>
       
            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
    </div>
</form>

<script>
        var formIndex = 0; // Initialize the global form index

        function createForm(index) {
            return `
                <div class="row">
                    <div class="col-md-6">
                        <label>Name</label>
                        <input type="text" name="name[${index}]" placeholder="Name" class="inputField">
                    </div>
                    <div class="col-md-6">
                        <label>Slot Price</label>
                        <input type="text" name="slot_price[${index}]" placeholder="Slot Price" class="inputField">
                    </div>
                    <div class="col-md-6">
                        <label>Breaktime Start</label>
                        <input type="time" name="breaktime_start[${index}]" placeholder="Breaktime Start" class="inputField">
                    </div>
                    <div class="col-md-6">
                        <label>Breaktime End</label>
                        <input type="time" name="breaktime_end[${index}]" placeholder="Breaktime End" class="inputField">
                    </div>
                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea name="court_description[${index}]" placeholder="Description" class="inputField"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="formButton delete" onclick="removeForm(${index})">Remove</span>
                    </div>
                </div>
            `;
        }

        function addSportsCourt() {
            const formContainer = document.getElementById("formContainer");
            const form = document.createElement("div");
            form.innerHTML = createForm(formIndex);
            formContainer.appendChild(form);
            formIndex++;
        }

        function removeForm(index) {
            const formContainer = document.getElementById("formContainer");
            const formToRemove = formContainer.children[index];
            formContainer.removeChild(formToRemove);
        }
    </script>

@endsection