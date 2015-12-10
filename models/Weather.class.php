<?php

require_once('../lib/db.interface.php');
require_once('../lib/db.class.php');

final class Weather 
{
	// Handles weather api (and database weather table?)



	private $dataSource;// = 'Local Cache';   
	private $cacheTimeLimit;// =10;
	private $lastCacheTime;// = 0;
	private $urlBase;// = 'api.openweathermap.org/data/2.5/weather?APPID='; 	
	private $defaultZip;// = 80524;   
	private $currentTempF;// = 0;
	

	public function __construct() 
	{
		// expects api key, openweathermapKey,  in session variable
		//  
		//$this->dataSource = 'Local Cache';   
		$this->cacheTimeLimit = 600; //(10 minutes)
		//$this->lastCacheTime = 0;
		$this->urlBase = 'api.openweathermap.org/data/2.5/weather?units=imperial&APPID='; 	
		$this->defaultZip = 80524;   
		$this->currentTempF = 99;
		
		if (session_status() == PHP_SESSION_NONE) {session_start();}
		if (!isset($_SESSION['lastCacheTime'])) 
		{
			$_SESSION['lastCacheTime'] = 0;	
		}
		
		if (isset($_SESSION['openweathermapKey']))
			$this->urlBase .= $_SESSION['openweathermapKey'];
		else
			die ("openweathermapKey not found in session");
	}

	public function getTemp(){return $this->currentTempF;}
	public function getSource(){return $this->dataSource;}


	public function RetrieveWeatherByCoordinates($lat,$lon)
	{
		//api.openweathermap.org/data/2.5/weather?lat={lat}&lon={lon}
		//40.730504, -105.084476
		//$lat = isset($lat)?$lat:40.730504;
		//$lon = isset($lon)?$lat:-105.084476;
		$url = $this->urlBase . '&lat='.$lat.'&lon='.$lon;
		$this->RetrieveWeather ($url);
	}
	public function RetrieveWeatherByZip ($zip)
	{
		$zip = isset($zip)?$zip:$this->$defaultZip;	
		$url = $this->urlBase . '&zip='.$zip.',us';
		$this->RetrieveWeather ($url);

	}
	
	private function RetrieveWeather ($url)
	{
		$currentTime = time();
		/*
		echo $url . '</ br>';
		echo $currentTime ." time </ br>";
		echo $this->lastCacheTime . '</ br>';
		echo $this->cacheTimeLimit . '</ br>';
		*/
		$timeLimit = $_SESSION['lastCacheTime'] + $this->cacheTimeLimit;
		if ( !isset($_SESSION['currentTempF']) or $currentTime > $timeLimit )
		{
			$this->dataSource = 'OpenWeatherMap';

			
		  // cURL calls
		  $curl = curl_init($url);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  $data = curl_exec($curl);
		  curl_close($curl);
		  
		  // Convert string data to json object
		  $json_obj = json_decode($data);
		  //var_dump($json_obj);
		  if(!isset($json_obj->main->temp)){
		    die ("Cannot retrieve weather; does the config file have a valid key?");
		  }
		  // Grap temp data
		  $this->currentTempF = $json_obj->main->temp;
		  
		  //save data
		  $_SESSION['lastCacheTime'] = $currentTime;
		  $_SESSION['currentTempF'] = $this->currentTempF;

		  // Grap temp data & convert to f
		  //$current_temp_kelvin = $json_obj->main->temp;
		  //$this->currentTempF = ($current_temp_kelvin - 273.15) * 1.8 + 32;
		  
		 //echo "Current Temp: " . $currentTempF . "&deg; Fahrenheit from " . $dataSource;
 
		}
		else
		{
			$this->dataSource='local cache';
			if ( isset($_SESSION['currentTempF'])) $this->currentTempF = $_SESSION['currentTempF'];

		}
		
		
		
	} //end RetrieveWeather
} //end class

?>