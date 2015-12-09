
	function locate(latId,lonId)
	{
	  if (navigator.geolocation) 
	  {
    	navigator.geolocation.getCurrentPosition(
	    	function(position) 
	    	{
		      var pos = {
		        lat: position.coords.latitude,
		        lng: position.coords.longitude
		      };

					document.getElementById(latId).value = pos.lat;
					document.getElementById(lonId).value = pos.lng;
	    	}, 
	    	document.write('<p> geolocator failed</p>')
	    );
  	} 
  	else 
  	{
	    // Browser doesn't support Geolocation
	    document.write ('<p> no geolocation </p>');
	  }
 	 
 
  }

