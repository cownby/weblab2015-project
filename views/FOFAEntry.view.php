  <?php 
 	include "../views/common/header.php";
	include "../views/common/RadioList.php";
?>

  
  <!-- Primary Container starts here -->
  <article class="fluid textContainer">
  
	<p align="right"><?php displayStatusMessage(); ?></p>
	<?php displayAdminControls($user); ?>

	<form action="entryTracker.php" method="get" class="textStyle fofa-form" >
      <h2 class="fluid showAreaH2 headingStyle"><?php echo $username ?>, add your flora information</h2>

		<input type="hidden" name="action" value="add_item">
		  <!--
	  		<input type="radio" name="observationType" value="plant" checked>Plant
	 		<input type="radio" name="observationType" value="animal">Animal
	     -->
	    <p><label for="plantName">Plant</label></p>
	    <input type="text" name="plantName" value="" required>        
		
        <p><label for="observationDate">Observation Date</label></p>
  		<input type="text" id="observationDate" name="observationDate" value="">
		 
		<p><label for="locationNotes">Location Notes</label></p>
  	    <input type="text" name="locationNotes" value="">
  
  	    <p><label>Latitude/Longitude</label></p>
	    <input type="text" id="lat" name="lat" value="">
		<input type="text" id="lon" name="lon" value="">
		  
		<p><label>Weather (temp)</label></p>
		<input type="text" name="tempF" value="<?php echo $weather->getTemp() ?>" >
		  	  
		<p><label>Soil Type</label></p>
		<div id="radioList">
		 <?php
	    	$list = new RadioList("soil",$ObservationMgr->getSoilTypes());
	    	echo $list->MakeMenuWithDBRows("","id","soil");
	    ?>	  	
		</div>
		  
		  <p><label>Notes</label></p>
		  <input type="text" name="notes" value="">
		  
		  <p><label>Submitter: <?php echo $username ?></label></p>

		  
		  <p><input type="submit" value="Save"  class='btn'></p>
  <!-- 
  <a href='entryTracker.php?action=add_item' class='btn'>Add</a>
  <input type="reset" value="Clear form" />
  -->
          
    </form>

  </article>

<?php

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
(function() 
{
  var location = '<?php echo $_SESSION["location"]; ?>';
  if (location == 'onSite') 
  {
   	locate();
   	setDefaultDate();
  }

   		
})();

	function setDefaultDate()
	{
		//TODO: add time
		
		var date = new Date();

		var day = date.getDate();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();

		if (month < 10) month = "0" + month;
		if (day < 10) day = "0" + day;

		var today = year + "-" + month + "-" + day;       
		document.getElementById("observationDate").value = today;
	}
	function locate()
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
					//document.write ('<p> latituted' + pos.lat + '</p>');
					//document.write ('<p> longitude' + pos.lng +'</p>');
					document.getElementById("lat").value = pos.lat;
					document.getElementById("lon").value = pos.lng;
					getWeather(pos.lat,pos.lng);
	    	}, 
	    	function()
	    	{
	    		//document.write('<p> geolocator failed</p>')
	    		document.getElementById("lat").value = 'geolocate failed';
				}	
	    );
  	} 
  	else 
  	{
	    // Browser doesn't support Geolocation
	    document.write ('<p> no geolocation </p>');
	  }
 	 
 
  }


  function getWeather(lat,lon)
  {
		var urlStr = "http://api.openweathermap.org/data/2.5/weather?lat="+ lat+"&lon"+lon
			+"&appid=32d87fad13abd43ddaf60e687ed1adc1" ;
			
      $.ajax({
          url: urlStr,
          timeout: 30000,
          method: 'GET',
          dataType: 'jsonp',
          success: function (data) {

						alert("success!");
						dump(data);
		
          },
          error: function (jqXHR, textStatus, errorThrown) {
              alert("Unable to retrieve weather data: " + errorThrown);
          }
      });
            
  }
</script>

  <!--Primary content area ends here--> 
  
  <!-- Footer starts here -->
  
  <footer class="fluid footer">
  <?php include_once "common/footer.php"; ?>
  </footer>
  <!--Footer ends here--> 
</div>
<!--Container ends here-->
</body>
</html>
