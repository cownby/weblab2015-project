<?php
	include_once "../models/User.class.php";
	
	function displayStatusMessage()
	{
		
		if (session_status() == PHP_SESSION_NONE) {session_start();}
		if (isset($_SESSION['FFuser']))
		{
			$user = unserialize($_SESSION['FFuser']);
			echo "Hello ". $user->getName() . ". ";
		}
			
		if (isset($_GET["msg"]))
		{
			$msg = $_GET["msg"];
		  echo "$msg";		
		}		
	}
	
	function displayAdminControls($user)
	{
		if (!isset($user))
		{
			$user = getSessionUser();
		}
		if ($user->isAdmin())
			include "../views/adminButton.view.php";
	}
	
	function getSessionUser()
	{
		$user = NULL;
		//start session if it isn't already
		if (session_status() == PHP_SESSION_NONE) {session_start();}
		
		//
		if (isset($_SESSION['FFuser']))
		{
			$user = unserialize($_SESSION['FFuser']);	
			if (FALSE == $user) die ("session user is invalid");	
		}
		else
		{
			$user = addGuestUserToSession();
		}
		
		if (NULL==$user)
			die ("Having a really hard time setting a user!")	;
		else
			return $user;
	}
	function addGuestUserToSession()
	{
			$userManager = new UserManager();
			$user = $userManager->getUserByEmail("guest");
			if ($user == FALSE) die ("Cannot access guest account");
			$_SESSION['FFuser'] = serialize($user);	
			return $user;
	}
?>