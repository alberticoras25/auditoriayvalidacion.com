/*Gmap Init*/
$(function () {
	"use strict";
	
	/* Map initialization js*/
	if( $('#map_canvas').length > 0 )
	{
		var centerLatitude = parseFloat($("#latMap").val());
		var centerLongitude = parseFloat($("#longMap").val());
		var zoomPosition = "google.maps.ControlPosition.LEFT_TOP";

		var mapStyle = [{"featureType":"administrative",
						"elementType":"labels.text.fill",
						"stylers":[{"color":"#444444"}]},
						{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},
						{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},
						{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e9e9e9"}]},
						{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#deebd8"},{"visibility":"on"}]},
						{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},
						{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},
						{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},
						{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},
						{"featureType":"water","elementType":"all","stylers":[{"color":"#c4e5f3"},{"visibility":"on"}]}];

		var settings =
		{
			zoom: 11,
			center: new google.maps.LatLng(21.1236, -101.68),
			mapTypeId: "roadmap",
			disableDefaultUI: true,
			zoomControlOptions: {
				position: eval(zoomPosition)
			},
			styles: eval(mapStyle)
	    };

		var map = new google.maps.Map(document.getElementById("map_canvas"), settings);
		google.maps.event.addDomListener(window, "resize", function()
		{
			var center = map.getCenter();
			google.maps.event.trigger(map, "resize");
			map.setCenter(center);
		});

		var infowindow = new google.maps.InfoWindow();
		var companyPos = new google.maps.LatLng(centerLatitude,centerLongitude);
		var companyMarker = new google.maps.Marker({
			position: companyPos,
			map: map,
			title:"Dirección",
			icon: "portal/assets/img/marker-small.png",
			draggable: true,
			zIndex: 3});

		google.maps.event.addListener(companyMarker, 'click', function()
		{
			infowindow.open(map,companyMarker);
		});

		google.maps.event.addListener(companyMarker, 'dragend', function (event)
		{
			$("#latMap").val(this.getPosition().lat());
			$("#longMap").val(this.getPosition().lng());
		});

		var input = document.getElementById('searchMapInput');
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		var autocomplete = new google.maps.places.Autocomplete(input);
		autocomplete.bindTo('bounds', map);

		var infowindow = new google.maps.InfoWindow();
		autocomplete.addListener('place_changed', function()
		{
			infowindow.close();
			companyMarker.setVisible(false);
			var place = autocomplete.getPlace();
			if(!place.geometry) {
				window.alert("El lugar devuelto de Autocompletar no contiene geometría");
				return;
			}

			/* If the place has a geometry, then present it on a map. */
			if (place.geometry.viewport)
			{
				map.fitBounds(place.geometry.viewport);
			}
			else
			{
				map.setCenter(place.geometry.location);
				map.setZoom(17);
			}

			companyMarker.setPosition(place.geometry.location);
			companyMarker.setVisible(true);
			var address = '';
			if (place.address_components)
			{
				address = [

					(place.address_components[0] && place.address_components[0].short_name || ''),

					(place.address_components[1] && place.address_components[1].short_name || ''),

					(place.address_components[2] && place.address_components[2].short_name || '')

				].join(' ');

			}

			infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
			infowindow.open(map, companyMarker);

			//Location details
			/*for(var i = 0; i < place.address_components.length; i++)
			{
				if(place.address_components[i].types[0] == 'route')
				{
					$("#calle").val(place.address_components[i].long_name);
				}
				if(place.address_components[i].types[0] == 'street_number')
				{
					$("#numExt").val(place.address_components[i].long_name);
				}
				if(place.address_components[i].types[0] == 'postal_code')
				{
					$("#zip").val(place.address_components[i].long_name);
				}
				if(place.address_components[i].types[0] == 'administrative_area_level_1')
				{
					//ESTADO
					var txtEstado = place.address_components[i].long_name;
				}
				if(place.address_components[i].types[0] == 'locality')
				{
					//CIUDAD
					var txtCiudad = place.address_components[i].long_name;
				}
				if(place.address_components[i].types[0] == 'sublocality_level_1')
				{
					//COLONIA
					var txtColonia = place.address_components[i].long_name;
				}
				if(place.address_components[i].types[0] == 'country')
				{
					//document.getElementById('country').innerHTML = place.address_components[i].long_name;
				}
			}*/

			/* Location details */
			$("#latMap").val(place.geometry.location.lat());
			$("#longMap").val(place.geometry.location.lng());

			/*$("#calle").val(place.postal_code);*/

			/*document.getElementById('location-snap').innerHTML = place.formatted_address;
			 document.getElementById('lat-span').innerHTML = place.geometry.location.lat();
			 document.getElementById('lon-span').innerHTML = place.geometry.location.lng();*/
		});
	}

	if( $('#map_canvas_1').length > 0 ){	
	var settings = {
		zoom: 16,
		center: new google.maps.LatLng(43.270441,6.640888),
		mapTypeControl: false,
		scrollwheel: false,
		draggable: true,
		panControl:false,
		scaleControl: false,
		zoomControl: false,
		streetViewControl:false,
		navigationControl: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		styles: [
		{
			"featureType": "water",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#e9e9e9"
				},
				{
					"lightness": 17
				}
			]
		},
		{
			"featureType": "landscape",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#f5f5f5"
				},
				{
					"lightness": 20
				}
			]
		},
		{
			"featureType": "road.highway",
			"elementType": "geometry.fill",
			"stylers": [
				{
					"color": "#ffffff"
				},
				{
					"lightness": 17
				}
			]
		},
		{
			"featureType": "road.highway",
			"elementType": "geometry.stroke",
			"stylers": [
				{
					"color": "#ffffff"
				},
				{
					"lightness": 29
				},
				{
					"weight": 0.2
				}
			]
		},
		{
			"featureType": "road.arterial",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#ffffff"
				},
				{
					"lightness": 18
				}
			]
		},
		{
			"featureType": "road.local",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#ffffff"
				},
				{
					"lightness": 16
				}
			]
		},
		{
			"featureType": "poi",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#f5f5f5"
				},
				{
					"lightness": 21
				}
			]
		},
		{
			"featureType": "poi.park",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#dedede"
				},
				{
					"lightness": 21
				}
			]
		},
		{
			"elementType": "labels.text.stroke",
			"stylers": [
				{
					"visibility": "on"
				},
				{
					"color": "#ffffff"
				},
				{
					"lightness": 16
				}
			]
		},
		{
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"saturation": 36
				},
				{
					"color": "#333333"
				},
				{
					"lightness": 40
				}
			]
		},
		{
			"elementType": "labels.icon",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "transit",
			"elementType": "geometry",
			"stylers": [
				{
					"color": "#f2f2f2"
				},
				{
					"lightness": 19
				}
			]
		},
		{
			"featureType": "administrative",
			"elementType": "geometry.fill",
			"stylers": [
				{
					"color": "#fefefe"
				},
				{
					"lightness": 20
				}
			]
		},
		{
			"featureType": "administrative",
			"elementType": "geometry.stroke",
			"stylers": [
				{
					"color": "#fefefe"
				},
				{
					"lightness": 17
				},
				{
					"weight": 1.2
				}
			]
		}
	]};		
	var map = new google.maps.Map(document.getElementById("map_canvas_1"), settings);	
	google.maps.event.addDomListener(window, "resize", function() {
		var center = map.getCenter();
		google.maps.event.trigger(map, "resize");
		map.setCenter(center);
	});	
	
	var infowindow = new google.maps.InfoWindow();	
	var companyPos = new google.maps.LatLng(43.270441,6.640888);	
	var companyMarker = new google.maps.Marker({
		position: companyPos,
		map: map,
		title:"Our Office",
		zIndex: 3});	
	google.maps.event.addListener(companyMarker, 'click', function() {
		infowindow.open(map,companyMarker);
	});
}
	if( $('#map_canvas_2').length > 0 ){	
	var settings = {
		zoom: 16,
		center: new google.maps.LatLng(43.270441,6.640888),
		mapTypeControl: false,
		scrollwheel: false,
		draggable: true,
		panControl:false,
		scaleControl: false,
		zoomControl: false,
		streetViewControl:false,
		navigationControl: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		 styles: [
		{
			"featureType": "administrative",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#444444"
				}
			]
		},
		{
			"featureType": "landscape",
			"elementType": "all",
			"stylers": [
				{
					"color": "#f2f2f2"
				},
				{
					"visibility": "on"
				}
			]
		},
		{
			"featureType": "landscape.natural",
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
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "road",
			"elementType": "all",
			"stylers": [
				{
					"saturation": -100
				},
				{
					"lightness": 45
				}
			]
		},
		{
			"featureType": "road.highway",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "simplified"
				}
			]
		},
		{
			"featureType": "road.arterial",
			"elementType": "labels.icon",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "transit",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "all",
			"stylers": [
				{
					"color": "#68ebb5"
				},
				{
					"visibility": "on"
				}
			]
		}
	]};		
	var map = new google.maps.Map(document.getElementById("map_canvas_2"), settings);	
	google.maps.event.addDomListener(window, "resize", function() {
		var center = map.getCenter();
		google.maps.event.trigger(map, "resize");
		map.setCenter(center);
	});	
	var contentString = '<div id="content-map-marker" style="text-align:left; padding-top:10px; padding-left:10px">'+
		'<div id="siteNotice">'+
		'</div>'+
		'<h6 id="firstHeading" class="firstHeading" style=" margin-bottom:0px;"><strong>Hello Friend!</strong></h4>'+
		'<div id="bodyContent">'+
		'<p style="font-family: Varela Round; color:#adadad; font-size:13px; margin-bottom:10px">Here we are. Come to drink a coffee!</p>'+
		'</div>'+
		'</div>';
	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});	
	
	var companyPos = new google.maps.LatLng(43.270441,6.640888);	
	var companyMarker = new google.maps.Marker({
		position: companyPos,
		map: map,
		title:"Our Office",
		zIndex: 3});	
	google.maps.event.addListener(companyMarker, 'click', function() {
		infowindow.open(map,companyMarker);
	});
}
});