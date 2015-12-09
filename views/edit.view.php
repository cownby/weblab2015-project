<?php
	$pageTitle = "WebLab 2015 Project - Add/Edit Observation";
	require_once 'common/header.php';
	require_once 'common/RadioList.php';
?>
<article class="fluid textContainer">
<p align="right"><?php displayStatusMessage(); ?></p>
<?php displayAdminControls($user); ?>
<h2 class="fluid showAreaH2 headingStyle">Add or Edit Item</h2>


<form action="adminController.php" method="get">
	<input type="hidden" name="action" value="save">
	<input type="hidden" name="id" value="<?= $item->getId() ?>">
	<input type="hidden" name="plantId" value="<?= $item->getPlantId() ?>">
	<input type="hidden" name="locationId" value="<?= $item->getLocationId() ?>">
	<input type="hidden" name="weatherId" value="<?= $item->getWeatherId() ?>">
	<input type="hidden" name="userId" value="<?= $item->getUserId() ?>">
 
  <p><label>Name</label></p>
  	<input type="text" name="name" value="<?= $item->getName() ?>"><br  />
  <p><label>Notes</label></p>
  	<input type="text" name="notes" value="<?= $item->getNotes() ?>"><br  />
  <p><label>Observation Date</label></p>
  	<input type="text" name="observationDate" value="<?= $item->getObservationDate() ?>"><br  />

	<div id="radioList">
	    <?php
	    	$list = new RadioList("soil",$ObservationMgr->getSoilTypes());
	    	echo $list->MakeDBRowMenuWithDefault("Soil Type?","id","soil",$item->getSoilTypeId());
	    	
	    ?>	
	</div>
	    
	<p><label>Degrees F</label></p>
  	<input type="text" name="tempF" value="<?= $item->getTempF(); ?>"><br  />
    <p><label>Latitude</label></p>
  	<input type="text" name="lat" value="<?= $item->getLat(); ?>"><br  />
    <p><label>Longitude</label></p>
  	<input type="text" name="lon" value="<?= $item->getLon(); ?>"><br  />  
    <p><label>Location Description</label></p>
  	<input type="text" name="locationNotes" value="<?= $item->getLocationNotes(); ?>"><br  />  
  <br  />
  <input type="submit" value="save"  class='btn'>
  
</form>
</article>

  <footer class="fluid footer">
  <?php include_once 'common/footer.php'; ?>
  </footer>
