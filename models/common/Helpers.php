<?php

	function dump($dataToDump)
	{
		print "<p> Data Dump: </p>";
		print "<pre>" . print_r($dataToDump,true)."</pre>";
		print "<p> EOD </p>";
	}
	function printBR($data)
	{
		print  $data ."<br />";
	}	
	function printP($data)
	{
		print  "<p>" . $data ."</p>";
	}
	
?>