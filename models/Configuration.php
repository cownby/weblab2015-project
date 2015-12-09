<?php
require_once "Helpers.php";

class Configuration
{
	//singleton class to house configuration data
	// instantiate with (for example) $config = Configuration::Instance();
	
	private $_configFile;
	private $_configArray;


		
	public function __construct() 
	{	
		$this->_configFile = "C:/config/configAPI.ini";
		$this->_configArray = parse_ini_file ( $this->_configFile );
		dump ($this->_configArray);
	}
	
	public function Get($key) { return $this->_configArray[$key]; }
		
}


?>