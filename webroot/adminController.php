<?php
	$pageTitle = "WebLab Flora ot Fauna Collection Project";
	
    require_once('../lib/db.interface.php');
    require_once('../lib/db.class.php');
    require_once('../models/allModels.php'); 
    require_once('utilities.php');
?>


<?php

	$ObservationMgr = new ObservationMgr();
	if (!isset($user))
	{
		if (session_status() == PHP_SESSION_NONE) {session_start();}
		$user = unserialize($_SESSION['FFuser']);	
	}


  $action = isset($_GET["action"])?$_GET["action"]:'';
  $target = isset($_GET["target"])?$_GET["target"]:'';

        
      switch ($action) 
      {
        case 'edit' :
        	$item = $ObservationMgr->getObservation($target);
        	include('../views/edit.view.php');
        	break;

        case 'save' :
          $arr = array();
          $arr["id"] = isset($_GET["id"])?$_GET["id"]:'';
          $arr["PlantName"] = isset($_GET["name"])?$_GET["name"]:'adminController:undefined';
          $arr["notes"] = isset($_GET["notes"])?$_GET["notes"]:'';
          $arr["observationDate"] = isset($_GET["observationDate"])?$_GET["observationDate"]:'';
          $arr["LocationNotes"] = isset($_GET["locationNotes"])?$_GET["locationNotes"]:'';
          $arr["Latitude"] = isset($_GET["lat"])?$_GET["lat"]:'9';
          $arr["Longitude"] = isset($_GET["lon"])?$_GET["lon"]:'9';
          $arr["DegreesF"] = isset($_GET["tempF"])?$_GET["tempF"]:'99';
          $arr["SoilId"] = isset($_GET["soil"])?$_GET["soil"]:'9';
          $arr["PlantId"] = isset($_GET["plantId"])?$_GET["plantId"]:0;
          $arr["LocationId"] = isset($_GET["locationId"])?$_GET["locationId"]:0;
          $arr["WeatherId"] = isset($_GET["weatherId"])?$_GET["weatherId"]:0;
          $arr["UserId"] = isset($_GET["userId"])?$_GET["userId"]:0;
          
          $item = new PlantObservation();
          $item->hydrate($arr);
          $ObservationMgr->save($item);
          $msg =  $arr["PlantName"] .' record added'; 
          
          header("Location: adminController.php?msg=$msg");
 
        	break;
        
        case 'manage_users':
        	header("Location: adminController.php?msg=User management isn't yet implemented");
        	break;
        	
        case 'shapefile_export':
        	header("Location: adminController.php?msg=Shapefile export isn't yet implemented");
        	break;
        	        	
        case 'csv_export':
        	$export = new DataExport();
          $rows = $ObservationMgr->getAllObservationsAsMSQLiObjects(); 
          $export->toCSV($rows);
          header("Location: adminController.php");
          break;                 
            
        default:
          //include('../views/FOFAEntry.view.php');
          $items = $ObservationMgr->getAllObservationRecords();
          include('../views/list.view.php');
          break;
      }
      
    ?>
  
</body>
</html>


