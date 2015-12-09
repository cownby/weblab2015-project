
<?php
	$pageTitle = "WebLab Project - View List";
	require_once 'common/header.php';
?>
<article class="fluid textContainer">
<p align="right"><?php displayStatusMessage(); ?></p>
<?php displayAdminControls($user); ?>
	
<h2 class="fluid showAreaH2 headingStyle">View Item List</h2>

<div class="fluid itemList">
	<div class="table-responsive">
	<table>
		<thead>
		<tr class="textStyle">
			<th>Id</th>
			<th>Name</th>
			<th>Date Observed</th>
			<th>Notes</th>
			<th>Observer</th>
			<th>Degrees F</th>
			<th>Latitude</th>
			<th>Longitude</th>
			<th>Location Desc</th>
			<th>Soil Type</th>
		</tr>
		</thead>
	  <?php foreach($items as $row){ ?>
	  <tr>
	    <td><?= $row['id'] ?></td>
	    <td><?= $row['PlantName'] ?></td>
	    <td><?= $row['observationDate'] ?></td>
	    <td><?= $row['notes'] ?></td>
	    <td><?= $row['UserName'] ?></td>
	    <td><?= $row['DegreesF'] ?></td>
	    <td><?= $row['Latitude'] ?></td>
	    <td><?= $row['Longitude'] ?></td>
	    <td><?= $row['LocationNotes'] ?></td>
	    <td><?= $row['SoilType'] ?></td>
	    <td><a href='adminController.php?action=edit&target=<?= $row['id'] ?>' class='editButton'>edit</a></td>
	  </tr>
	  <?php } ?>
	</table> 
	</div>  

 
 </div>
 </article>
    
    
    
    
