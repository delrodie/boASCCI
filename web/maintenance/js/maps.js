 var googleMapSelector = $('#maps'),
     myCenter = new google.maps.LatLng(23.810332, 90.41251809999994);

 function initialize() {
     var mapProp = {
         center: myCenter,
         zoom: 10,
         scrollwheel: false,
         mapTypeId: google.maps.MapTypeId.ROADMAP,
         styles: [
    {
        "featureType": "administrative",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    }
]
     };
     var map = new google.maps.Map(document.getElementById("maps"), mapProp);
     var marker = new google.maps.Marker({
         position: myCenter,
         animation: google.maps.Animation.BOUNCE,
         icon: 'images/map-marker.png'
     });
     marker.setMap(map);
 }
 if (googleMapSelector.length) {
     google.maps.event.addDomListener(window, 'load', initialize);
 }