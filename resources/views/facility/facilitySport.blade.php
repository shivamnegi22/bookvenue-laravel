@extends('layouts.aside')
@section('content')

<form method="POST" enctype="multipart/form-data" action="{{ url('sports-facility') }}">
    @csrf
    <div class="container">
        <div class="row form">
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
                <span id="addAccordionItem" class="formButton add">Add New Accordion Item</span>
            </div>
            <div class="col-md-12">
                <div class="accordion" id="accordionExample">

                </div>
            </div>

            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>


<script>
function createAccordionItem(index) {
    const newItem = `
                <div class="card">
                    <div class="card-header" id="heading${index}">
                        <h5 class="mb-0">
                            <button class="btn collapsed" type="button" data-toggle="collapse"
                                data-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">
                                Collapsible Group Item #${index}
                            </button>
                        </h5>
                    </div>
                    <div id="collapse${index}" class="collapse" aria-labelledby="heading${index}"
                        data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <input type="text" name="name" placeholder="Name" class="inputField">
                                </div>
                                <div class="col-md-6">
                                    <label>Slot Price</label>
                                    <input type="text" name="slot_price" placeholder="Slot Price" class="inputField">
                                </div>
                                <div class="col-md-6">
                                    <label>Breaktime Start</label>
                                    <input type="time" name="breaktime_start" placeholder="Breaktime Start" class="inputField">
                                </div>
                                <div class="col-md-6">
                                    <label>Breaktime End</label>
                                    <input type="time" name="breaktime_end" placeholder="Breaktime End" class="inputField">
                                </div>
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea type="text" name="description" placeholder="Description" class="inputField"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
    return newItem;
}

document.getElementById('addAccordionItem').addEventListener('click', function() {
    const accordionContainer = document.querySelector('.accordion');
    const newItemIndex = accordionContainer.children.length + 1;
    const newItemHTML = createAccordionItem(newItemIndex);

    const newItemElement = document.createRange().createContextualFragment(newItemHTML);
    accordionContainer.appendChild(newItemElement);
});
</script>
@endsection