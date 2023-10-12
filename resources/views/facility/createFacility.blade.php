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
                <button class="formButton submit w-100 mt-4">Location&nbsp;&nbsp;<i class="fa fa-map-marker"></i></button>
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