<?php
class MySql
{
		private $host;
		private $db;
		private $user;
		private $pswd;
		
	function __construct($host='',$db='',$user='',$pswd='')
	{
		
		if($host =='') 
			$host = DB_HOST;

		if($db =='') 
			$db = DB_NAME;
		
		if($user =='') 
			$user = DB_USER;
		
		if($pswd =='') 
			$pswd = DB_PSWD;
		
		
		$this->host = $host;
		$this->db = $db;
		$this->user = $user;
		$this->pswd = $pswd;
		$this->mySqlObj = new mysqli($host,$user,$pswd,$db);

	}
	public function query($query)
	{
		if( ! $resultObj = $this->mySqlObj->query($query))
		{
			$error = 'Set';
			$this->sendError($error);
		}
		return $resultObj;
	}

	public function getArray($query,$type=MYSQL_ASSOC)
	{
		if( ! $resultObj = $this->mySqlObj->query($query))
		{
			$error = 'Problem with query';
			$this->sendError($error);
		}
		
		if($resultObj->num_rows)
		{
			$data = array();
			while ($row = $resultObj->fetch_array($type))
			{
				$data[] = $row;
			}
			return $data;
		}
		else
		{
			return false;
		}
	}
	
	public function sendError($error)
	{
		die;
	}
}
?>