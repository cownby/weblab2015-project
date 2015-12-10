<?php
	$pageTitle = "WebLab Flora ot Fauna Collection Project";
	
    require_once('../lib/db.interface.php');
    require_once('../lib/db.class.php');
    require_once('../models/allModels.php'); 
    require_once('utilities.php');
?>


<?php

	$ObservationMgr = new ObservationMgr();
	$weather = new Weather();
	$weather->RetrieveWeatherByCoordinates(40.73,-105.085);
	
	if (isset($_SESSION['FFuser']))
		$user = unserialize($_SESSION['FFuser']);
	else
	{
		$userMgr = new UserManager;
		$user = $userMgr->getUserByEmail("guest");
		if (FALSE == $user)	die ("Cannot access guest account");
	}
	$username = $user->getName(); //need for display purposes


  $action = isset($_GET["action"])?$_GET["action"]:'';
        
      switch ($action) {
          
        case 'add_item':
        	$item = new PlantObservation();
          $arr = array();
          $arr["id"] = isset($_GET["id"])?$_GET["id"]:'';
          $arr["PlantName"] = isset($_GET["plantName"])?$_GET["plantName"]:'entryTracker:undefined';
          $arr["notes"] = isset($_GET["notes"])?$_GET["notes"]:'entryTracker:unset';
          $arr["observationDate"] = isset($_GET["observationDate"])?$_GET["observationDate"]:'';
          $arr["LocationNotes"] = isset($_GET["locationNotes"])?$_GET["locationNotes"]:'entryTracker:unset';
          $arr["Latitude"] = isset($_GET["lat"])?$_GET["lat"]:'9';
          $arr["Longitude"] = isset($_GET["lon"])?$_GET["lon"]:'9';
          $arr["DegreesF"] = isset($_GET["tempF"])?$_GET["tempF"]:'99';
          $arr["SoilId"] = isset($_GET["soil"])?$_GET["soil"]:'0';
          $arr["UserId"] = $user->getId();

          $item->hydrate($arr);
          $ObservationMgr->save($item);
          $msg =  $arr["PlantName"] .' record added'; 
          
          header("Location: entryTracker.php?msg=$msg");
          
          break;                 
            
        default:

          include('../views/FOFAEntry.view.php');
          break;
      }
    ?>
  
</body>
</html>


