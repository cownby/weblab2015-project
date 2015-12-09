<?php 
abstract class EntryManager {
	protected $_db;
	
	function __construct() {
		$this->_db = new Db();
	}
	
  public function defineWeather($objWeather)
  {
  	
  }
  public function defineLocation($objLocation) 
  {
  }
  
  public function delete($id){
    
    if(!is_numeric($id)) return FALSE;
    
      $results = $this->db -> query("DELETE from plant where id = $id");
  }
  

}
