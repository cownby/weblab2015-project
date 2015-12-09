<?php

?>
<?php
class LocationMgr 
{
	private $_geoplugin;
	private $_lat;
	private $_lon;
	
	function __construct() 
	{
		$this->_geoplugin = unserialize( 
			file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']) );
			
		//$this->_lat = 0;
		//$this->_lon = 0;
		$this->GetIpLocation();
	}
	
	public function GetIpLocation()
	{
		if ( is_numeric($this->_geoplugin['geoplugin_latitude'])  
		 &&  is_numeric($this->_geoplugin['geoplugin_longitude']) ) 
		 { 
			$this->_lat = $this->_geoplugin['geoplugin_latitude'];
			$this->_long = $this->_geoplugin['geoplugin_longitude'];
		}
	}
	
	  public function getLat(){return $this->_lat;}
	  public function getLon(){return $this->_lon;}

}

function AsDownloaded()
{
	

	$geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']) );
	 
	if ( is_numeric($geoplugin['geoplugin_latitude']) && is_numeric($geoplugin['geoplugin_longitude']) ) {
	 
		$lat = $geoplugin['geoplugin_latitude'];
		$long = $geoplugin['geoplugin_longitude'];
		//set farenheight for US
		if ($geoplugin['geoplugin_countryCode'] == 'US') {
			$tempScale = 'fahrenheit';
			$tempUnit = '&deg;F';
		} else {
			$tempScale = 'celsius';
			$tempUnit = '&deg;C';
		}
		require_once('ParseXml.class.php');
	 
		$xml = new ParseXml(); 
		$xml->LoadRemote("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query={$lat},{$long}", 3);
		$dataArray = $xml->ToArray();
	 
		$html = "<center><h2>Weather forecast for " . $geoplugin['geoplugin_city'];
		$html .= "</h2><table cellpadding=5 cellspacing=10><tr>";
	 
		foreach ($dataArray['simpleforecast']['forecastday'] as $arr) {
	 
			$html .= "<td align='center'>" . $arr['date']['weekday'] . "<br />";
			$html .= "<img src='http://icons-pe.wxug.com/i/c/a/" . $arr['icon'] . ".gif' border=0 /><br />";
			$html .= "<font color='red'>" . $arr['high'][$tempScale] . $tempUnit . " </font>";
			$html .= "<font color='blue'>" . $arr['low'][$tempScale] . $tempUnit . "</font>";
			$html .= "</td>";
	 
	 
		}
		$html .= "</tr></table>";
	 
		echo $html;
	}
 }
?>