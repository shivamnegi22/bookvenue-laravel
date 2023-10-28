jQuery.noConflict();
jQuery(document).ready(function($) {
    
    function ajaxGetRequest(url, callback) {
        $.ajax({
            type: 'GET', // You can modify this to handle other HTTP methods like POST, PUT, etc.
            url,
            success: function(response) {
                callback({
                    error: false,
                    data: response,
                });
            },
            error: function(xhr, status, error) {
                callback({
                    error: true,
                    message: error,
                });
            },
        });
    }


    $('#facility_id').change(function(){
        ajaxGetRequest(`/get-service/${$(this).val()}`, function(response) {
            if (response.error === false) {
                // Handle success'
                renderServices(response.data);
            } else {
                // Handle error
                console.error(response.message,'error is this on response');
            }
    })
    });

    function renderServices(data){

        $('#servicesWrapper').removeClass("d-none");

        let options = ["<option value='' hidden>Choose service</option>"]
        if(data && data.length > 0){
            data.map((items)=>{
                return options.push(`<option value="${items.id}">${items.name}</option>`)
            })
        }
        $("#service_id").html(options);
        $(".hideForm").addClass('d-none');
    }

    $('#service_id').change(function(){
        if($(this).val()) $(".hideForm").removeClass('d-none');
    });

    //  handle start and end time validation
    
    var startTimeInput = document.getElementById("startTime");
    var endTimeInput = document.getElementById("endTime");


    function validateTimeDifference() {

        if($(this).attr('id') == "endTime"){
            if(startTimeInput.value == ''){

                $(this).val('');
                $('#startTimeError').removeClass('d-none')
            }
            else{
                $('#startTimeError').addClass('d-none')
            }
        }else{
            $('#startTimeError').addClass('d-none')
        }

        var startTimeValue = new Date("2000-01-01T" + startTimeInput.value);
        var endTimeValue = new Date("2000-01-01T" + endTimeInput.value);

        var timeDifference = endTimeValue - startTimeValue;

        if (timeDifference < 0 || timeDifference < 15 * 60 * 1000) {
            $("#endTimeValError").removeClass('d-none')
            endTimeInput.value = "";
        }
        else{
            $("#endTimeValError").addClass('d-none')
        }

        validateBreaks();
    }

    startTimeInput.addEventListener("change", validateTimeDifference);
    endTimeInput.addEventListener("change", validateTimeDifference);

    var BreakStartInput = document.getElementById("breakStart");
    var BreakEndInput = document.getElementById("breakEnd");
    
    function validateBreaks() {
        if(!startTimeInput.value || !endTimeInput.value){
            $(this).val('');
        }

        var minValue = new Date("2000-01-01T" + startTimeInput.value);
        var maxValue = new Date("2000-01-01T" + endTimeInput.value);
        var breakStartValue = new Date("2000-01-01T" + BreakStartInput.value);
        var breakEndValue = new Date("2000-01-01T" + BreakEndInput.value);

        if( minValue <= breakStartValue && maxValue >= breakStartValue && minValue <= breakEndValue && maxValue >= breakEndValue  ){

            if (breakStartValue >= breakEndValue ) {
                BreakEndInput.value = "";
            }
        }
        else{
            if(minValue > breakStartValue || maxValue < breakStartValue){
                BreakStartInput.value = "";
            }
            if(minValue <= breakEndValue || maxValue >= breakEndValue){
                BreakEndInput.value = "";
            }
        }
    }

    
    BreakStartInput.addEventListener("change", validateBreaks);
    BreakEndInput.addEventListener("change", validateBreaks);

    //end validation check

    $('#addBreaks').click(function(){

        var requiredFields = $('#addBreakForm input');
        var missingFields = [];

        requiredFields.each(function() {
            if ($(this).val() === '') {
                missingFields.push($(this).attr('id'));
            }
        });

        if(missingFields.length > 0){
            return alert('Please fill all fields first.')
        }

        var clonedFormRow = $('#addBreakForm').clone();
        let uniqueId = Date.now();

        $('#addBreakForm input').val('');
        clonedFormRow.find(':input').prop('readonly', true);
        clonedFormRow.removeAttr('id');
        clonedFormRow.attr('id', uniqueId);
        clonedFormRow.find(':input').removeAttr('id');

        clonedFormRow.find('.col-md-2').html(`<button type="button" class="btn btn-danger"  onclick="removeBreak(${uniqueId})">Remove</button>`);
        $('#addBreakFormWrapper').append(clonedFormRow);
    })



    

    $('#addMoreCourts').click(function() {
        // Clone the #courtsForm element

        var requiredFields = $('#courtsForm [required]');
        var missingFields = [];
        $('#courtsForm .text-danger').addClass('d-none');

        requiredFields.each(function() {
            if ($(this).val() === '') {
                missingFields.push($(this).attr('id'));
            }
        });

        if(missingFields.length > 0){
           return missingFields.map((item)=>{
                $(`#${item}Error`).removeClass('d-none');
            })
        }


        var clonedForm = $('#courtsForm').clone();
        let uniqueId = Date.now();

        $('#courtsForm :input').val('');
        
        $('#addBreakFormWrapper .row').not('#addBreakForm').remove();

        // Clear the input fields in the cloned form
        clonedForm.find(':input').prop('readonly', true);
        clonedForm.find(':input').removeAttr('id');
        clonedForm.find('.text-danger').remove();
        clonedForm.find('#addBreakFormWrapper .row').removeAttr('id');
        clonedForm.find('#addBreakFormWrapper .col-md-5').removeClass("col-md-5").addClass("col-md-6");
        clonedForm.find('#addBreakFormWrapper .col-md-2').remove();
        clonedForm.attr('id', uniqueId);

        
        let index = $("#courtsFormWrapper .courtsForm").length;
        clonedForm.find("input, textarea, select").each(function() {
            var currentName = $(this).attr("name");
            var newName = currentName.replace("[0]", `[${index}]`);
            $(this).attr("name", newName);
        });

        clonedForm.append(`<div class="col-md-4 my-3"><button type="button" class="btn btn-danger" onclick="removecourt(${uniqueId})">Remove court</button></div>`)
        
        // Append the cloned form to the target location
        $('#courtsFormWrapper').append(`<h4 class='newFormHead' id="court${uniqueId}"><span>Court</span></h4>`);
        $('#courtsFormWrapper').append(clonedForm);
        
    });
});

function removecourt(courtRowId) {
    var element = document.getElementById(courtRowId);
    
    if (element) {
        if (window.confirm('Are you sure you want to remove this court?')) {
            element.parentNode.removeChild(element);
            document.getElementById(`court${courtRowId}`).remove();
        }
    }
    return null;
}

function removeBreak(breakRowId) {
    var element = document.getElementById(breakRowId);
    
    if (element) {
        if (window.confirm('Are you sure you want to remove this break?')) {
            element.parentNode.removeChild(element);
        }
    }
    return null;
}