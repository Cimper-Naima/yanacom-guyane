(function ($) {
	PPGoogleMap = function (settings) {

		this.id                = settings.id;
		this.nodeClass         = '.fl-node-' + this.id;
		this.mapElement        = $(this.nodeClass).find('.pp-google-map');
		this.scrollZoom        = settings.scrollZoom;
		this.dragging          = settings.dragging;
		this.streetView        = settings.streetView;
		this.zoomControl       = settings.zoomControl;
		this.fullscreenControl = settings.fullscreenControl;
		this.mapType           = settings.mapType;
		this.mapTypeControl    = settings.mapTypeControl;
		this.markerAnimation   = settings.markerAnimation;
		this.mapSkin           = settings.mapSkin;
		this.mapStyleCode      = ( '' != settings.mapStyleCode ) ? jQuery.parseJSON(settings.mapStyleCode) : '';
		this.isBuilderActive   = settings.isBuilderActive;
		this.markerData        = settings.markerData;
		this.markerName        = settings.markerName;
		this.markerPoint       = settings.markerPoint;
		this.markerImage       = settings.markerImage;
		this.infoWindowText    = settings.infoWindowText;
		this.enableInfo        = settings.enableInfo;
		this.zoomType          = settings.zoomType;
		this.mapZoom           = settings.mapZoom;
		this.hideTooltip       = settings.hideTooltip;

		this.latlng = new google.maps.LatLng( this.markerData[0]['latitude'], this.markerData[0]['longitude'] );

		this.mapOptions = {
			zoom:              this.mapZoom,
			center:            this.latlng,
			mapTypeId:         this.mapType,
			mapTypeControl:    this.mapTypeControl,
			streetViewControl: this.streetView,
			zoomControl:       this.zoomControl,
			fullscreenControl: this.fullscreenControl,
			gestureHandling:   this.scrollZoom,
			styles:            this.mapStyleCode,
			draggable:         ( $( document).width() > 641 ) ? true : this.dragging,
			gestureHandling:   this.scrollZoom,
		}

		if ( 'drop' == this.markerAnimation ) {
			this.markerAnimation = google.maps.Animation.DROP;
		} else if ( 'bounce' == this.markerAnimation ) {
			this.markerAnimation = google.maps.Animation.BOUNCE;
		} else {
			this.markerAnimation = '';
		}

		this._init();
	}

	PPGoogleMap.prototype = {
		_init: function () {

			var map 		= new google.maps.Map( this.mapElement[0], this.mapOptions );
			var infowindow 	= new google.maps.InfoWindow();
			var bounds      = new google.maps.LatLngBounds();

			for (i = 0; i < this.markerData.length; i++) {

				var icon 		= '',
					lat 		= this.markerData[i]['latitude'],
					lng 		= this.markerData[i]['longitude'],
					info_win 	= this.infoWindowText[i],
					title 		= this.markerName[i],
					icon_type 	= this.markerPoint[i],
					icon_url 	= this.markerImage[i];

				if ( lat != '' && lng != '') {

					if ( icon_type == 'custom') {

						icon = {
							url: icon_url
						};
					}
					if ( 'auto' === this.zoomType ) {	
						var loc = new google.maps.LatLng(lat, lng);
						bounds.extend(loc);
						map.fitBounds(bounds);
					}

					var marker = new google.maps.Marker({
						position:	new google.maps.LatLng(lat, lng),
						map: 		map,
						title: 		title,
						icon: 		icon,
						animation: 	this.markerAnimation,
					});

					if ( '' != info_win && 'yes' == this.enableInfo[i] ) {
						var contentString = '<div class="pp-infowindow-content">';
							contentString += info_win;
							contentString += '</div>';

						var infowindow = new google.maps.InfoWindow({
							content: contentString,
						});

						infowindow.open(map, marker);

					}
					// Event that closes the Info Window with a click on the map
					google.maps.event.addListener( map, 'click', ( function ( infowindow ) {
						return function () {
							infowindow.close();
						}
					})(infowindow));

					if ( 'yes' === this.hideTooltip ) {
						infowindow.close();
					};

					if ( '' != info_win && 'yes' == this.enableInfo[i] ) {
						var self = this;
						google.maps.event.addListener( marker, 'click', (function ( marker, i ) {
							return function () {
								var contentString = '<div class="pp-infowindow-content">';
									contentString += self.infoWindowText[i];
									contentString += '</div>';

								infowindow.setContent( contentString );

								infowindow.open( map, marker );
							}
						})(marker, i));
					}
				}
			}
		},
		_autoZoon: function () {
			var map = new google.maps.Map( this.mapElement[0], this.mapOptions );
			for (i = 0; i < this.markerData.length; i++) {

			var lat = this.markerData[i]['latitude'],
				lng = this.markerData[i]['longitude'];

			if ( lat != '' && lng != '') {
				var latlng = [
					new google.maps.LatLng( lat, lng ),
				]; 
			}

			}
			var latlngbounds = new google.maps.LatLngBounds();
			for (var i = 0; i < latlng.length; i++) {
				latlngbounds.extend(latlng[i]);
			}
			map.fitBounds(latlngbounds);
		}
	}

})(jQuery);