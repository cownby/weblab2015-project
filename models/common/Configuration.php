<?php
//require_once "Helpers.php";

class Configuration
{
	//read config file and save in session 
	//  also retains configurat
	
	private $_configFile;
	private $_configArray;

		
	public function __construct($configFile) 
	{	        
	
		if (ISSET($configFile) )
			$this->_configFile = $configFile;
		else
			$this->_configFile = "C:/config/config.ini";
		
		$this->_configArray = parse_ini_file ( $this->_configFile );

	}
	
	public function Get($key) 
	{ 
		return $this->_configArray[$key]; 
	}
	
	public function SaveInSession()
	{
		try 
		{
			if (!isset($this->_configArray) )
			{ 
				throw new Exception("There is no configuration to save");
			}
			if (session_status() == PHP_SESSION_NONE) {session_start();}
			foreach ($this->_configArray as $key => $val)
			{
				$_SESSION[$key] = $val;
			}		
		}
		catch (Exception $e) 
		{
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}


?>