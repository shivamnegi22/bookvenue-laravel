var courtsData = [];

document.getElementById("addForm").addEventListener("click", function () {
  var formContainer = document.getElementById("formsContainer");
  var courtData = {
    name: "",
    startTime: "",
    endTime: "",
    prize: "",
    duration: "",
    breaks: []
  };

  var form = document.createElement("div");
  form.classList.add("form-container");

  form.innerHTML = `
    <form class="row mb-3">
      <div class="col-md-4">
        <label>Name</label>
        <input class="inputField" type="text" name="court_name" required>
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

  // Add event listeners to input fields to update the courtData
  form.querySelectorAll('[name="court_name"], .startTime, .endTime, [name="prize"]').forEach(function (field) {
    field.addEventListener('input', function () {
      courtData.name = form.querySelector('[name="court_name"]').value;
      courtData.startTime = form.querySelector('.startTime').value;
      courtData.endTime = form.querySelector('.endTime').value;
      courtData.prize = form.querySelector('[name="prize"]').value;
      courtData.duration = form.querySelector('[name="duration"]').value;
    });
  });

  // Add the current courtData to the array
  courtsData.push(courtData);

  // Function to calculate duration
  function calculateDuration() {
    var start = new Date("2023-10-16T" + form.querySelector(".startTime").value + ":00");
    var end = new Date("2023-10-16T" + form.querySelector(".endTime").value + ":00");

    if (!form.querySelector(".startTime").value || !form.querySelector(".endTime").value) {
      form.querySelector(".duration").value = "";
      return;
    }

    var diff = end - start;

    var minutes = Math.floor((diff / 1000 / 60) % 60);
    var hours = Math.floor((diff / 1000 / 60 / 60) % 24);

    form.querySelector(".duration").value = hours + "h " + minutes + "m";
  }

  function checkFields() {
    var name = form.querySelector('[name="court_name"]').value;
    var startTime = form.querySelector('.startTime').value;
    var endTime = form.querySelector('.endTime').value;
    var addButton = form.querySelector('.add');

    if (name && startTime && endTime) {
      addButton.disabled = false;
    } else {
      addButton.disabled = true;
    }
  }

  form.querySelectorAll('[name="court_name"], .startTime, .endTime').forEach(function (field) {
    field.addEventListener('input', function () {
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
    var courtIndex = courtsData.indexOf(courtData);
    if (courtIndex !== -1) {
      courtsData.splice(courtIndex, 1);
    }
    formContainer.removeChild(form);
  });

  // handle break time slot click
  form.querySelector(".add").addEventListener("click", function () {
    var timesContainer = form.querySelector(".timesContainer");

    var timeGroup = document.createElement("div");
    timeGroup.classList.add("form-container");

    var breakTime = {
      start_Time: "",
      end_Time: ""
    };

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

    // Find the corresponding court in the courtData array
    timeGroup.querySelectorAll('.startTime, .endTime').forEach(function (field) {
      field.addEventListener('input', function () {
        breakTime.start_Time = timeGroup.querySelector('[name="start_Time"]').value;
        breakTime.end_Time = timeGroup.querySelector('[name="end_Time"]').value;
      });
    });

    // Add the break time object to the courtData
    courtData.breaks.push(breakTime);

    // Add event listener to remove time group
    timeGroup.querySelector(".delete").addEventListener("click", function () {
      var breakIndex = courtData.breaks.indexOf(breakTime);
      if (breakIndex !== -1) {
        courtData.breaks.splice(breakIndex, 1);
      }
      timesContainer.removeChild(timeGroup);
    });

    // Add event listeners to new start time and end time fields
    timeGroup.querySelector(".startTime").addEventListener("input", calculateDuration);
    timeGroup.querySelector(".endTime").addEventListener("input", calculateDuration);
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
    var start = new Date("2023-10-16T" + form.querySelector(".startTime").value + ":00");
    var end = new Date("2023-10-16T" + form.querySelector(".endTime").value + ":00");

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

  console.log(courtsData);

  var courtDataJson = JSON.stringify(courtsData);

  $(".submit").submit(function(event) {

    let request_method = $(this).attr("method"); //get form GET/POST method

    let form_data = $(this).serialize();


    



//     $.ajax({

//   type: request_method,
//   url: 'addServices/',
//   data: form_data, // Convert data to a JSON string if needed
//   contentType: 'application/json', // Set the content type to JSON
//   success: function(response) {
//     // Handle the response when the request is successful
//     console.log(response);
//   },
//   error: function(xhr, status, error) {
//     // Handle errors
//     console.error('AJAX request failed: ' + status + ', ' + error);
//   }
// });



});
});


// Mutli DateSelector

document.addEventListener('DOMContentLoaded', function() {
  flatpickr("#datePicker", {
      mode: "multiple",
      minDate: "today",
      dateFormat: "d-m-Y"
  });
});