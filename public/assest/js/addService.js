$( document ).ready(function() {

    
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
                console.log(response.data,'data is this on response');
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

        // Clear the input fields in the cloned form
        clonedForm.find(':input').prop('readonly', true);
        clonedForm.find(':input').removeAttr('id');
        clonedForm.find('.text-danger').remove();
        clonedForm.attr('id', uniqueId);
        clonedForm.append(`<div class="col-md-4 d-flex justify-content-center align-items-center"><button type="button" class="btn btn-danger" onclick="removecourt(${uniqueId})">Remove court</button></div>`)
        
        // Append the cloned form to the target location
        $('#courtsFormWrapper').append(clonedForm);
    });

});

function removecourt(courtRowId){
    if (window.confirm('Are you sure you want to remove this court?')) {
        $(`#${courtRowId}`).remove();
    }
    return null;
}