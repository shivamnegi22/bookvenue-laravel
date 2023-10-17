@extends('layouts.aside')
@section('content')

@section('breadcrumb')
<ul class="cd-breadcrumb">
    <li><a href="#0">Dashboard</a></li>
    <li><a href="#0">Service Management</a></li>
    <li class="current"><em>Category</em></li>
</ul>
@endsection

<form method="post" action="{{url('#')}}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row form">
            <div class="col-md-6">
                <label>Choose Facility</label>
                <select class="inputField" name="facility_id" id="facilitySelect">
                    <option value="" hidden>Choose Facility</option>
                    <option value="Venue">Venue</option>
                    <option value="Sport">Sport</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Choose Service</label>
                <select class="inputField" name="services_type" id="services_type">
                    <option value="" hidden>Choose Service</option>
                    <option value="Venue">Venue</option>
                    <option value="Sport">Sport</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Feature Image</label>
                <input type="file" name="" class="form-control-file">
            </div>
            <div class="col-md-4">
                <label>Images</label>
                <input type="file" name="" class="form-control-file" multiple>
            </div>
            <div class="col-md-4">
                <label>Holiday</label>
                <input type="text" name="" class="inputField">
            </div>
            <div class="col-md-12">
                <label>Description</label>
                <textarea class="inputField" rows="5" name="description" placeholder="Description"></textarea>
            </div>
            <div class="col-md-12 mb-3">
                <button type="button" class="formButton add" id="addForm">Add Court</button>
            </div>
            <div class="col-md-12" id="formsContainer"></div>
            <div class="col-md-12">
                <button type="submit" class="formButton submit" name="submit">Save</button>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById("addForm").addEventListener("click", function () {
  var formContainer = document.getElementById("formsContainer");

  var form = document.createElement("div");
  form.classList.add("form-container");

  form.innerHTML = `
                <form class="row mb-3">
                    <div class="col-md-4">
                        <label>Name</label>
                        <input class="inputField" type="text" name="name" required>
                    </div>
                    <div class="col-md-4">
                        <label>Start Time</label>
                        <input class="inputField startTime" type="time" name="startTime" required>
                    </div>
                    <div class="col-md-4">
                        <label>End Time</label>
                        <input class="inputField endTime" type="time" name="endTime" required>
                    </div>
                    <div class="col-md-4">
                        <label>Prize</label>
                        <input class="inputField" type="text" name="prize" required>
                    </div>
                    <div class="col-md-4">
                        <label>Duration</label>
                        <div class="customCounter">
                            <button type="button" class="duration-control minus" data-action="minus">-</button>
                            <input class="inputField duration" type="text" name="duration" readonly value="">
                            <button type="button" class="duration-control plus" data-action="plus">+</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="formButton mt-4 w-100 add" disabled>Add Time for Break</button>
                    </div>
                    <div class="col-md-12 timesContainer"></div>
                    <div class="col-md-12">
                        <button type="button" class="formButton delete">Remove</button>
                    </div>
                </form>
            `;

  formContainer.appendChild(form);

  // Function to calculate duration
  function calculateDuration() {
    var start = new Date(
      "2023-10-16T" + form.querySelector(".startTime").value + ":00"
    );
    var end = new Date(
      "2023-10-16T" + form.querySelector(".endTime").value + ":00"
    );

    if (
      !form.querySelector(".startTime").value ||
      !form.querySelector(".endTime").value
    ) {
      form.querySelector(".duration").value = "";
      return;
    }

    var diff = end - start;

    var minutes = Math.floor((diff / 1000 / 60) % 60);
    var hours = Math.floor((diff / 1000 / 60 / 60) % 24);

    form.querySelector(".duration").value = hours + "h " + minutes + "m";
  }

  function checkFields() {
	var name = form.querySelector('[name="name"]').value;
	var startTime = form.querySelector('.startTime').value;
	var endTime = form.querySelector('.endTime').value;
	var addButton = form.querySelector('.add');

	if (name && startTime && endTime) {
		addButton.disabled = false;
	} else {
		addButton.disabled = true;
	}
}

form.querySelectorAll('[name="name"], .startTime, .endTime').forEach(function(field) {
	field.addEventListener('input', function() {
		calculateDuration();
		validateDuration();
		checkFields();
	});
});

  // Add event listener to calculate duration
  form.querySelector(".startTime").addEventListener("input", function () {
    calculateDuration();
    validateDuration();
  });
  form.querySelector(".endTime").addEventListener("input", function () {
    calculateDuration();
    validateDuration();
  });

  // Add event listener to remove form
  form.querySelector(".delete").addEventListener("click", function () {
    formContainer.removeChild(form);
  });

  // handle break time slot click
  form.querySelector(".add").addEventListener("click", function () {
    var timesContainer = form.querySelector(".timesContainer");

    var timeGroup = document.createElement("div");
    timeGroup.classList.add("form-container");

    timeGroup.innerHTML = `
                    <div class="row">
                        <div class="col-md-4">
                            <label>Start Time</label>
                            <input class="inputField startTime" type="time" name="start_Time" required>
                        </div>
                        <div class="col-md-4">
                            <label>End Time</label>
                            <input class="inputField endTime" type="time" name="end_Time" required>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="formButton delete mt-4 w-100">Remove</button>
                        </div>
                    </div>
                `;

    timesContainer.appendChild(timeGroup);

    // Add event listener to remove time group
    timeGroup.querySelector(".delete").addEventListener("click", function () {
      timesContainer.removeChild(timeGroup);
    });

    // Add event listeners to new start time and end time fields
    timeGroup
      .querySelector(".startTime")
      .addEventListener("input", calculateDuration);
    timeGroup
      .querySelector(".endTime")
      .addEventListener("input", calculateDuration);
  });

  // handle duration adjustment
  form.querySelectorAll(".duration-control").forEach(function (button) {
    button.addEventListener("click", function () {
      var durationField = form.querySelector(".duration");
      var currentDuration = durationField.value;
      var hours = parseInt(currentDuration.split("h")[0], 10);
      var minutes = parseInt(currentDuration.split(" ")[1].split("m")[0], 10);

      if (this.dataset.action === "plus") {
        minutes += 45;
        if (minutes >= 60) {
          hours += 1;
          minutes = 0;
        }
      } else if (this.dataset.action === "minus") {
        // Ensure the minimum duration is 45 minutes
        if (hours === 0 && minutes <= 45) {
          alert("Duration cannot be less than 45 minutes.");
          return;
        }

        minutes -= 45;
        if (minutes < 0) {
          hours -= 1;
          minutes = 60 + minutes;
        }
      }

      durationField.value = hours + "h " + minutes + "m";
      validateDuration();
    });
  });

  // Function to validate duration
  function validateDuration() {
    var start = new Date(
      "2023-10-16T" + form.querySelector(".startTime").value + ":00"
    );
    var end = new Date(
      "2023-10-16T" + form.querySelector(".endTime").value + ":00"
    );

    var durationField = form.querySelector(".duration");
    var currentDuration = durationField.value;
    var hours = parseInt(currentDuration.split("h")[0], 10);
    var minutes = parseInt(currentDuration.split(" ")[1].split("m")[0], 10);

    var calculatedEndTime = new Date(start);
    calculatedEndTime.setHours(calculatedEndTime.getHours() + hours);
    calculatedEndTime.setMinutes(calculatedEndTime.getMinutes() + minutes);

    if (calculatedEndTime > end) {
      alert("Duration exceeds end time. Please adjust the duration.");
      durationField.value = "";
    }
  }
});
</script>

@endsection