/**
 * -----------------------------------------------------------------------------
 * Creado Por     | David Alejandro Domínguez Rivera
 * Fecha Creación | 16/Ago/2018 16:35 
 * -----------------------------------------------------------------------------
 * Empresa        | InOutDelivery 
 * Aplicación     | webfront-yii2
 * Desarrolladores| David Alejandro Domínguez Rivera                      (DADR)
 * -----------------------------------------------------------------------------
 * Historial de modificaciones:
 * (DADR) 16/Ago/2018 16:35 - 16/Ago/2018 16:35 = Test[success]
 * -    Se creo el ThemeAsset (basado en el AppAsset), el cual se encargara de 
 *      gestionar los contenidos de los diferentes temas de la aplicación 
 *      alojados en la carpeta themes.
 */

initMap();

function initMap() {

    let geocoder = new google.maps.Geocoder();
    let location = new google.maps.LatLng(4.71098859, -74.072092);
    let map = new google.maps.Map(document.getElementById('map'), {
        center: location,
        zoom: 17,
        disableDefaultUI: true,
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        fullscreenControl: true,
        fullscreenControlOptions: {
            position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
    });

    let marker = new google.maps.Marker({
        position: location,
        map: map
    });

    map.addListener('click', function (event) {
        let newLocation = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
        geocodeLatLng(geocoder, map, marker, newLocation);
    });

    let input = document.getElementById('addressGeocode');
    let searchBox = new google.maps.places.SearchBox(input);

    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener('places_changed', function () {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        var bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }

            marker.setPosition(place.geometry.location);
            map.panTo(marker.getPosition());

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            let currentPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            geocodeLatLng(geocoder, map, marker, currentPosition);
        }, function () {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function codeAddress(geocoder, map, marker, address) {
    geocoder.geocode({'address': address}, function (results, status) {
        if (status === 'OK') {
            marker.setPosition(results[0].geometry.location);
            map.panTo(marker.getPosition());
//            $('#latlngGeocode').val(results[0].geometry.location);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function geocodeLatLng(geocoder, map, marker, location) {
    geocoder.geocode({'location': location}, function (results, status) {
        if (status === 'OK') {
            if (results[0]) {
                $.map(results[0].address_components, function (item) {
                    if (item.types.indexOf('locality') != -1) {
                        $('#cityGeocode').val(item.long_name);
                    }
                    if (item.types.indexOf('country') != -1) {
                        $('#countryGeocode').val(item.long_name);
                    }
                });
                $('#addressGeocode').val(results[0].formatted_address);
                var latlng = [];
                latlng.push(location.lat());
                latlng.push(location.lng());

                $('#locationGeocode').val(JSON.stringify({lat:location.lat(), lng:location.lng()}));
                marker.setPosition(location);
                map.panTo(marker.getPosition());
//                codeAddress(geocoder, map, marker, $('#addressGeocode').val());
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}