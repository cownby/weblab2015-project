<?php 

class ObservationMgr 
{
	protected $_db;
	protected $_fullSelectList;
	protected $_fullSelectClause;
	
	function __construct() 
	{
		$this->_db = new Db();
		//parent::__construct();
		$this->_fullSelectList = "o.*" 
			. ",p.id as PlantId,p.name as PlantName" 
			. ",s.id as SoilId,s.soil as SoilType" 
			. ",l.id as LocationId,l.lat as Latitude,l.lon as Longitude,l.locationNotes as LocationNotes" 
			. ",w.id as WeatherId,w.tempF as DegreesF,w.windMPH as windMPH,w.weatherNotes as WeatherNotes"
			. ",u.id as UserId,u.name as UserName,u.email as UserEMail" 
			;
		$this->_fullSelectClause = "SELECT " . $this->_fullSelectList .
					" from observations o " .
  				" inner join plants p on (o.plantId = p.id) " .
					" left outer join locations l on (o.locationId = l.id) " .
					" left outer join soiltypes s on (o.soilTypeId = s.id) " .
					" left outer join weather w on (o.weatherId = w.id) " .
					" left outer join users u on (o.userId = u.id) ";
	}	

  public function getObservation($itemId)
  {  
    	// retrieve one item from plant table
    	// input: plant table Id
    	// output: array of plant observation information
    	
    	if(!is_numeric($itemId)) return FALSE;

		try{
    
      	$id = $this->_db -> quote($itemId);
				$stmt =  $this->_fullSelectClause  .
					" where o.id = $id limit 1";
      	$results = $this->_db -> select($stmt);
      	
				$err = $this->_db->error();
		    if (!empty($err))
		    {
					throw new Exception("ObservationMgr.getObservation: Problem retrieving observation. ".$err);
				}
      
		    foreach($results as $result)
		    {
						$item = new PlantObservation();
		        $item->hydrate($result);
		     }
		     return $item;
		}
		catch   (Exception $e) 
		{
			error_log('Caught exception: ' . $e->getMessage(),0);
			return FALSE;
		}       

    
	}
	public function getAllObservationRecords()
	{
  	//retrieve all observations from the database
  	

  	$selectStmt = $this->_fullSelectClause  .
	  			"order by p.name";
		 	  			
  	try
  	{
	    $rows = $this->_db -> select($selectStmt);
	    
	    // test for error conditions
      $err = $this->_db->error();
	    if (!empty($err) or FALSE == $rows)
	    	throw new Exception("ObservationMgr.getAllObservationRecords: Observation select failed. \n$selectStmt Error: $err");
    }
    catch   (Exception $e) 
		{
    	error_log( 'Caught exception: '.  $e->getMessage() );
    	$rows = FALSE;

		}      
    return $rows;    
      
	}
	  
	public function getAllObservationsAsMSQLiObjects()
	{
  	//retrieve all observations from the database
  	
  	//since every table has an id, list observations last so the id column returned
  	// has the observation id.
  	$selectStmt = $this->_fullSelectClause  .
	  			"order by p.name";
		 	  			
  	try
  	{
	    $rows = $this->_db -> query($selectStmt);
	    
	    // test for error conditions
      $err = $this->_db->error();
	    if (!empty($err)) 
	    	throw new Exception("getAllObservationsAsMSQLiObjects: Observation select failed: $selectStmt  \nError: $err");
    }
    catch   (Exception $e) 
		{
    	error_log( 'Caught exception: '.  $e->getMessage() );
    	$rows = FALSE;

		}      
    return $rows;    
      
	}
	
	public function getAllObservations()
	{
  	//retrieve all observations from the database
  	
		$data = array();  	  			
  	try
  	{
	    $rows = getAllObservationRecords;
			foreach($rows as $result)
			{
				$item = new PlantObservation();
		    $item->hydrate($result);
	      $data[] = $item;
	    }
    }
    catch   (Exception $e) 
		{
    	error_log( 'Caught exception: '.  $e->getMessage() );
		}      
    return $data;    
      
	}
	
	public function getSoilTypes()
	{
		// retrieve soil type options from database as an
		// associative array of 'id','soil' pairs
		try
		{
			//throw new Exception("use array for test purposes");
			$soilArray = $this->_db -> select("select id,soil from soilTypes");
		}
		catch  (Exception $e) 
		{
    	error_log('ObservationMgr.getSoilTypes exception: ' . $e->getMessage(),0);
			//return default array
			$soilArray = ["sand","silt","clay","loam","peat","gravel","rocky"];
		}
		return ($soilArray);
	}	
		public function getSoilType($soilTypeId)
	{
		// retrieve soil type from database
		$soilType = "";
		try
		{
			$result = $this->_db -> select("select soil from soilTypes where id=$soilTypeId");
			$err = $this->_db->error();
	    if (!empty($err) or FALSE == $result)
	    	throw new Exception("ObservationMgr.getSoilType: select failed for soil type with id=($soilTypeId): ".$err);
	    $soilType = $result[0]['soil'];
	  }
		catch  (Exception $e) 
		{
    	error_log('Caught exception: ' . $e->getMessage(),0);
		}
		return ($soilType);
		
	}	
	
	public function save($plantObservation)
	{
    
    	if ($plantObservation->getID()) 
    	{
				$this->_update($plantObservation);
    	} 
    	else 
    	{
    		
      	$this->_add($plantObservation);
		}
  }
   
  private function _quoteOrNull($val)
  {
		if (empty($val))
    {
    	return ("NULL");
		}
		else
		{
			return ($this->_db -> quote($val));
		}
	}
	  private function _numberOrNull($val)
  {
		if ( empty($val) or !is_numeric($val))
    {
    	return ("NULL");
		}
		else
		{
			return ($val);
		}
	}

  private function _add($item)
  {

    $notes = $this->_quoteOrNull($item->getNotes());
    $dateObserved = $this->_quoteOrNull($item->getObservationDate());
    $soilTypeId = $this->_numberOrNull($item->getSoilTypeId());
    
		//plant name is a required input
		$name = $this->_db -> quote($item->getName());
    $plantId = $this->_db -> insert("insert into plants (name) values ($name);");

    $locationId = $this->_addLocation($item);
		$weatherId = $this->_addWeather($item);
		
    //user
    if (empty($item->getUserId()))
			$userId = 1; //or guest?
		else
			$userId = $this->_db -> quote($item->getUserId());

		try
		{		
			$insertStmt = "insert into observations (notes, observationDate,plantId,weatherId,soilTypeId,locationId,userId) values "
				. "($notes, $dateObserved,$plantId,$weatherId,$soilTypeId,$locationId,$userId);";
	    $ObsId = $this->_db -> insert($insertStmt);
	 		$err = $this->_db->error();
	    if (!empty($err))
	    {
				throw new Exception("ObservationMgr._add: Problem inserting observation. ".$err);
			}
		}
		catch   (Exception $e) 
		{
			error_log('Caught exception: ' . $e->getMessage(),0);
		}  
  }
    
  private function _update($item)
  {
    $id = $this->_quoteOrNull($item->getId());
    $notes = $this->_quoteOrNull($item->getNotes());
    $dateObserved = $this->_quoteOrNull($item->getObservationDate());
    $soilTypeId = $this->_quoteOrNull($item->getSoilTypeId());

		$stmt = "update observations set notes=$notes, observationDate=$dateObserved, soilTypeId=$soilTypeId where id=$id";
		$result = $this->_db -> query($stmt);
 		$err = $this->_db->error();
    if (!empty($err))
    {
			throw new Exception("ObservationMgr._update: Problem updating. ".$err);
		}
		
		$this->_updatePlant($item);
		$this->_updateWeather($item);
		$this->_updateLocation($item);
		
  }
 
 	//Plants
  private function _addPlant($item)
   {
  	$id = "NULL";
  	try
  	{
			//plant name is a required input
			$name = $this->_db -> quote($item->getName());
	    $id = $this->_db -> insert("insert into plants (name) values ($name);");
	
	    $err = $this->_db->error();
	    if (!empty($err))
	    {
				throw new Exception("ObservationMgr._addPlant: Problem inserting plant. ".$err);
			}
 
		}
		catch   (Exception $e) 
		{
			error_log('Caught exception: ' . $e->getMessage(),0);
		} 
		return ($id); 
	 	
	 }	 
  	private function _updatePlant($item)
   {
  	$id = $item->getPlantId();
  	try
  	{
			$name = $this->_db -> quote($item->getName());
	    $result = $this->_db -> query("update plants set name=$name where id=$id");
	
	    $err = $this->_db->error();
	    if (!empty($err))
	    {
				throw new Exception("_updatePlant: Problem updating plant ($id): $err");
			}
 
		}
		catch   (Exception $e) 
		{
			error_log('Caught exception: ' . $e->getMessage(),0);
		}  
	 	
	 }

	//Weather
  private function _addWeather($item)
   {
  	$Id = "NULL";
  	try
  	{
	    if (!empty($item->getTempF()))
			{
				$tempF = $this->_db -> quote($item->getTempF());
	    	$Id = $this->_db -> insert("insert into weather (tempF) values ($tempF);");

		    $err = $this->_db->error();
		    if (!empty($err))
		    {
					throw new Exception("_addWEather: Problem inserting weather. ".$err);
				}
			} 
		}
		catch   (Exception $e) 
		{
			error_log('Caught exception: ' . $e->getMessage(),0);
		} 
		return ($Id); 
	 	
	 } 
   private function _updateWeather($item)
  {	
  	try
  	{
  		$id = $this->_quoteOrNull($item->getWeatherId());
  		if ("NULL" == $id)
  			throw new Exception("_updateWeather: Cannot update weather without an id.");
  			
	    if (!empty($item->getTempF()))
			{
				$tempF = $this->_db -> quote($item->getTempF());
	    	$result = $this->_db -> query("update weather set tempF = $tempF where id=$id;");

		    $err = $this->_db->error();
		    if (!empty($err))
		    {
					throw new Exception("_updateWeather: ".$err);
				}
			} 
		}
		catch   (Exception $e) 
		{
			error_log('Caught exception: ' . $e->getMessage(),0);
		} 

	}
	
	 
  // Location 
  private function _addLocation($item)
  {
  	$locationId = "NULL";
  	try
  	{
  		$lat = $item->getLat();
  		$lon = $item->getLon();
  		$notes = $item->getLocationNotes();
	    if ( !empty($item->getLat()) or !empty($item->getLon()) or !empty($item->getLocationNotes()) )
	    {
		    $lat = $this->_quoteOrNull($item->getLat());
		    $lon = $this->_quoteOrNull($item->getLon());
		    $locationNotes = $this->_quoteOrNull($item->getLocationNotes());    
		    $locationId = $this->_db -> insert("insert into locations (lat,lon,locationNotes) values ($lat,$lon,$locationNotes);");	
		    $err = $this->_db->error();
		    if (!empty($err))
		    {
					throw new Exception("_addLocation: Problem inserting location. ".$err);
				}
			} 
		}
		catch   (Exception $e) 
		{
			error_log('Caught exception: ' . $e->getMessage(),0);
		} 
		return ($locationId); 
	}  
   private function _updateLocation($item)
  {	
  	try
  	{
  		$id = $this->_numberOrNull($item->getLocationId());
  		if ("NULL" == $id)
  			throw new Exception("_updateLocation: Cannot update location without an id.");
  			
	    //if ( empty($item->getLat()) or empty($item->getLon()) or empty($item->getLocationNotes()) )
	    //{
		    $lat = $this->_numberOrNull($item->getLat());
		    $lon = $this->_numberOrNull($item->getLon());
		    $locationNotes = $this->_quoteOrNull($item->getLocationNotes());  
		    $stmt = "update locations set lat=$lat,lon=$lon,locationNotes=$locationNotes where id=$id";
		    $result = $this->_db -> query($stmt);	
		    $err = $this->_db->error();
		    if (!empty($err))
		    {
					throw new Exception("_updateLocation: $err \nquery: $stmt");
				}
			//} 
		}
		catch   (Exception $e) 
		{
			error_log('Caught exception: ' . $e->getMessage(),0);
		} 

	}

	
}

