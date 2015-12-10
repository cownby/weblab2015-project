<?php

/**
 * Plant Object
 */
class PlantObservation {
  
  private $_id;
  private $_observationDate;
  private $_notes;
  private $_soilTypeId;
  
  private $_name;
  private $_plantId;
  
  private $_userId;
  //private $_submitterFirstName;
  //private $_submitterLastName;
  //private $_submitterEmail;
  
  private $_locationId;
  private $_lat;
  private $_lon;
  private $_locationNotes;
  
  private $_weatherId;
  private $_tempF;
  private $_windMPH;
  private $_weatherDesc;
   
  //private $_locationObj;
  //private $_soilObj;
  //private $_weatherObj;
  //private $_userObj;

  public function getId(){return $this->_id;}
  public function setId($arg){$this->_id = $arg;}
  
  public function getName(){return $this->_name;}
  public function setName($arg){$this->_name = $arg;}

  public function getNotes(){return $this->_Notes;}
  public function setNotes($arg){$this->_Notes = $arg;}
    
  public function getObservationDate(){return $this->_observationDate;}
  public function setObservationDate($arg)
  {
  	if ("0000-00-00" == $arg)
  		$this->_observationDate = '';
  	else
  		$this->_observationDate = $arg;
  } 
 
  public function getLat(){return $this->_lat;}
  public function setLat($arg){$this->_lat = $arg;}       
  public function getLon(){return $this->_lon;}
  public function setLon($arg){$this->_lon = $arg;} 
  public function getLocationNotes(){return $this->_locationNotes;}
  public function setLocationNotes($arg){$this->_locationNotes = $arg;}   
  public function getLocationId(){return $this->_locationId;}
  public function setLocationId($arg){$this->_locationId = $arg;} 
   
  public function getTempF(){return $this->_tempF;}
  public function setTempF($arg){$this->_tempF = $arg;}  
  public function getWeatherId(){return $this->_weatherId;}
  public function setWeatherId($arg){$this->_weatherId = $arg;} 
  
  public function getSoilTypeId(){return $this->_soilTypeId;}
  public function setSoilTypeId($arg){$this->_soilTypeId = $arg;}  
 
  public function getPlantId(){return $this->_plantId;}
  public function setPlantId($arg){$this->_plantId = $arg;} 
 
  public function getUserId(){return $this->_userId;}
  public function setUserId($arg){$this->_userId = $arg;} 
 
 	public function getNameStr(){
		return "PlantName";
	}
   
  public function hydrate($arr) {
  	
    $this->setId(isset($arr["id"])?$arr["id"]:'');
    $this->setNotes(isset($arr["notes"])?$arr["notes"]:'plantObs:unset');
    $this->setObservationDate(isset($arr["observationDate"])?$arr["observationDate"]:'');
    
    $this->setName(isset($arr["PlantName"])?$arr["PlantName"]:'plantObs:unset');
    $this->setPlantId(isset($arr["PlantId"])?$arr["PlantId"]:0);
            
    $this->setTempF(isset($arr["DegreesF"])?$arr["DegreesF"]:'');
    $this->setWeatherId(isset($arr["WeatherId"])?$arr["WeatherId"]:'');   
    
    $this->setLat(isset($arr["Latitude"])?$arr["Latitude"]:'');    
    $this->setLon(isset($arr["Longitude"])?$arr["Longitude"]:'');  
    $this->setLocationNotes(isset($arr["LocationNotes"])?$arr["LocationNotes"]:'plantObs:unset'); 
    $this->setLocationId(isset($arr["LocationId"])?$arr["LocationId"]:''); 
      
    $this->setSoilTypeId(isset($arr["SoilId"])?$arr["SoilId"]:'');   
    
    $this->setUserId(isset($arr["UserId"])?$arr["UserId"]:'');     
   
    
  }
 

 
}

