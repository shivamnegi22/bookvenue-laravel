@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Facility Management</a></li>
    <li class="current"><em>Create Facility</em></li>
</ul>
@endsection

<form method="post" action="{{url('createFacility')}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-6 m20">
                <label>Facility Type</label>
                <div class="d-flex">
                    <div style="margin-right:1rem;">
                        <input type="radio" id="sports" name="facility_type" value="sports" class="">
                        <label for="html">Sports</label>
                    </div>
                    <div>
                        <input type="radio" id="venue" name="facility_type" value="venue">
                        <label for="css">Venue</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label>Official Name</label>
                <input type="text" name="name" placeholder="Official Name" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Alias</label>
                <input type="text" name="alias" placeholder="Alias" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Amenities</label>
                <!-- <input type="text" name="amenities" placeholder="Amenities" class="inputField"> -->
                <select class="js-example-data-ajax inputField" id="amenities" name="states[]" multiple="multiple">
                    <option value="AL">Alabama</option>
                    <option value="WY">Wyoming</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Address</label>
                <input type="text" name="address" placeholder="Address" class="inputField">
            </div>
            <div class="col-md-6">
                <label>Featured Image</label>
                <input type="file" name="featured_image" placeholder="" class="form-control-file">
            </div>
            <div class="col-md-4">
                <label>Latitude</label>
                <input type="text" name="latitude" placeholder="Latitude" class="inputField" readonly>
            </div>
            <div class="col-md-4">
                <label>Longitude</label>
                <input type="text" name="longitude" placeholder="Longitude" class="inputField" readonly>
            </div>
            <div class="col-md-4">
                <button type="button" class="formButton submit w-100 mt-4" data-toggle="modal"
                    data-target="#exampleModalCenter">
                    Location&nbsp;&nbsp;<i class="fa fa-map-marker"></i></button>
            </div>
            <div class="col-md-12 mb-3">
                <label>Description</label>
                <textarea id="editor" name="description" placeholder="Description"></textarea>
            </div>
            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3">
                    <h5 class="modal-title" id="exampleModalLongTitle">Select Location</h5>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <input type="text" name="address" placeholder="Search Location" class="inputField">
                    </div>
                    <div class="col-md-5">
                        <button type="button" class="formButton submit w-100" data-toggle="modal"
                            data-target="#exampleModalCenter" style="padding:6px 10px">
                            Use Current Location&nbsp;&nbsp;<i class="fa fa-map-marker"></i></button>
                    </div>
                </div>
                <div class="googleMap mb-3">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22415.696909658825!2d77.99858498023525!3d30.32634080668854!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39092a9d312d2add%3A0x2881f11554c636b7!2sGIKS%20INDIA%20PRIVATE%20LIMITED!5e0!3m2!1sen!2sin!4v1697174102861!5m2!1sen!2sin"
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="formButton bg-secondary px-5" data-dismiss="modal">Cancel</button>
                    <button type="button" class="formButton submit px-5">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
//
// jQuery - Select2 - AJAX - CNDJS Datasource
//
jQuery.noConflict();
jQuery(document).ready(function($) {
    $(".js-example-data-ajax").select2({
        ajax: {
            url: "https://api.cdnjs.com/libraries/", // comment
            dataType: "json",
            delay: 250,
            data: function(params) {
                return {
                    search: params.term, // "search" = match the expected API URL variable
                    page: params.page,
                    fields: "version,filename,description"
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;

                data = jQuery.map(data.results, function(obj) {
                    obj.id = obj.name;
                    obj.text = obj.description;
                    obj.latest = obj.latest;
                    obj.version = obj.version;
                    obj.filename = obj.filename;
                    return obj;
                });

                return {
                    results: data,
                    pagination: {
                        more: params.page * 30 < data.total_count
                    }
                };
            },
            success: function(data) {
                // for debug purposes
                console.log("SUCCESS: ", data);
            },
            error: function(data) {
                // for debug purposes
                console.log("ERROR: ", data);
            },
            cache: true
        },
        placeholder: "Search...",
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo(data) {
        if (data.loading) {
            return data.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__name'></div>" +
            "<div class='select2-result-repository__latest'></div>" +
            "<div class='select2-result-repository__version'></div>" +
            "<div class='select2-result-repository__filename'></div>" +
            "<div class='select2-result-repository__description'></div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__name").text(data.id);
        $container.find(".select2-result-repository__latest").text(data.latest);
        $container.find(".select2-result-repository__version").text(data.version);
        $container.find(".select2-result-repository__filename").text(data.filename);
        $container.find(".select2-result-repository__description").text(data.text);

        return $container;
    }

    function formatRepoSelection(data) {
        return data.id || data.text;
    }
});
</script>

@endsection