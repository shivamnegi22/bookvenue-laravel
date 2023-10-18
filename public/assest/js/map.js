// Map.js

var coords = null;
var allSuggestionsData = [];
var map;
var marker;


function initMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            // coords = { lat, lng };
            var mapOptions = {
                center: { lat, lng },
                zoom: 12,
            };

            map = new google.maps.Map(
                document.getElementById("map"),
                mapOptions
            );

            marker = new google.maps.Marker({
                position: { lat, lng },
                map: map,
                draggable: true,
                title: "Your Location",
            });
            // Add an event listener to get the coordinates when the marker is dragged
            google.maps.event.addListener(marker, "dragend", function (event) {
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();
				coords = {lat, lng}
            });
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

const handleInputChange = (e) => {
    const inputValue = e.value;
    document.getElementById("suggestions").innerHTML = "";
	document.getElementById("suggestions").classList.add("d-none");
    if (inputValue.length < 2) {
        return null;
    }

    // Use Google Places Autocomplete API to fetch suggestions
    const autoCompleteService =
        new window.google.maps.places.AutocompleteService();
    autoCompleteService.getPlacePredictions(
        { input: inputValue, componentRestrictions: { country: "IN" } },
        (predictions, status) => {
            if (status === window.google.maps.places.PlacesServiceStatus.OK) {
                
                var suggestions = [];
                if (predictions.length > 0) {
					allSuggestionsData = predictions;
                    predictions.map((item) => {
                        let suggetionData = [];

                        if (item.description.includes(",")) {
                            suggetionData = item.description.split(",", 2);
                        }

                        {
                            suggetionData.length == 2
                                ? suggestions.push(
                                      `<li class='suggestion-item' onclick="handleSelectOption('${item.place_id}')">
                    <p class='suggestion-heading'>${suggetionData[0]}</p>
                    <p class='suggestion-desc'>${suggetionData[1]}</p>
                </li>`
                                  )
                                : suggestions.push(`<li class='suggestion-item' onclick="handleSelectOption('${item.place_id}')">
                <p class='suggestion-heading'>${suggestion.description}</p>
                
                </li>`);
                        }
                    });
                
				document.getElementById("suggestions").classList.remove("d-none");
                document.getElementById("suggestions").innerHTML = suggestions.join("");
				}
            }
        }
    );
};


function handleSelectOption(placeId){
    // Get the place details using the Place Details service
    const placeService = new window.google.maps.places.PlacesService(document.createElement('div'));
    placeService.getDetails(
      { placeId },
      (result, status) => {
        if (status === window.google.maps.places.PlacesServiceStatus.OK) {
			document.getElementById("suggestions").innerHTML = "";
			document.getElementById("suggestions").classList.add("d-none");
			coords = { lat: result.geometry.location.lat(), lng: result.geometry.location.lng() }
			moveMarkerToCoords(coords)
        //   if(cb == undefined){
			//   console.log({ lat: result.geometry.location.lat(), lng: result.geometry.location.lng() },'coordinate of selected place')
            // navigate(`/location/${result.name}`, { state: { lat: result.geometry.location.lat(), lng: result.geometry.location.lng() } });
        //   }
        //   else{
        //     cb({coords: { lat: result.geometry.location.lat(), lng: result.geometry.location.lng() }, result})
        //   }
        }
      }
    );
  };

  function useCurrentLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
			coords = {lat,lng}
			moveMarkerToCoords(coords)
        });
	} else {
        alert("Geolocation is not supported by this browser.");
    }
  }

  function moveMarkerToCoords(lat, lng) {
	var newLatLng = new google.maps.LatLng(lat, lng);
	marker.setPosition(newLatLng);
	map.setCenter(newLatLng);
}

	function confirmLocation(){
		if(coords && coords != null){
			document.getElementById("latitude").value = coords.lat
			document.getElementById("longitude").value = coords.lng
		}
	}

// End Map.js