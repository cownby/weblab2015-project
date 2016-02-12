<?php
	$pageTitle = "WebLab Flora ot Fauna Collection Project";
	
	error_reporting(E_ALL);
	
  require_once('../lib/db.interface.php');
  require_once('../lib/db.class.php');
  require_once('../models/allModels.php'); 	
  require_once('utilities.php');
?>


<?php  
	$intermediateConfigFile = 'config.ini';
	if (! file_exists ( $intermediateConfigFile ))
	{
		die ("index.php; Intermediate config file not found: " . $intermediateConfigFile);
	}
	$configArray = parse_ini_file ( $intermediateConfigFile );
	$config = new Configuration($configArray['realConfigFile']);
  $config->SaveInSession();

	$action = isset($_GET["action"])?$_GET["action"]:'';
  $user = NULL;
     
  switch ($action) {
    case 'onSite':
    	$_SESSION['location'] = $action;
			if (!isset($_SESSION['FFuser'])) addGuestUserToSession();
      header('Location: entryTracker.php');
      break;    
     
    case 'atHome':  
    	$_SESSION['location'] = $action;
			if (!isset($_SESSION['FFuser'])) addGuestUserToSession();
      header('Location: entryTracker.php');
      break;
      
    case 'register':
    	$userManager = new UserManager();
    	$roles = $userManager->getAllRoles();
    	$user = new User();
			include('../views/userRegister.view.php'); 
			break; 

		case 'register_user':
			$error = registerUser();
			header("Location: index.php?msg=$error");
    	break;			
			   
    case 'login' :
    	unset($_SESSION['FFuser']);
			include('../views/login.view.php'); 
			break;
		
		case 'login_check':
	    $userManager = new UserManager();
	    $email = isset($_GET["email"])?$_GET["email"]:'guest';
	    $pass = isset($_GET["pass"])?$_GET["pass"]:'';
	    $user = $userManager->authenticate($email, $pass);
	    if (FALSE == $user )
	    	$msg = "login failed; please try again.";
      else
      {
				if (session_status() == PHP_SESSION_NONE) {session_start();}
				$_SESSION['FFuser'] = serialize($user);
				$msg = $user->getName() . " logged in";
			} 
			header("Location: index.php?msg=$msg");
			break;
			        
    default:        
      include('../views/Chooser.view.php');
      break;
  }
 ?>
  
<?php

	function registerUser()
	{
		$stat = '';
		try
		{
    	$userManager = new UserManager();
    	if(! $userManager->getUserId($_GET["email"]))
    	{
	    	$user = new User();
    		$user->hydrate(populateUserArrayFromGet());
    		$userManager->save($user);
    		if (session_status() == PHP_SESSION_NONE) {session_start();}
				$_SESSION['FFuser'] = serialize($user);
    		$stat = 'Registration successful; '.$user->getName() . " logged in";
    	}
    	else
    		$stat = 'Duplicate user email';

		}
		catch (Exception $e)
		{
			error_log('Caught exception: ' . $e->getMessage(),0);
			$stat = $e->getMessage();
		}			
		return $stat;

	}
	
	function populateUserArrayFromGet()
	{
		$arr = array();
		$arr['email'] = isset($_GET["email"])?$_GET["email"]:'guest';
	  $arr['pass'] = isset($_GET["pass"])?$_GET["pass"]:'';
	  $arr['name'] = isset($_GET["name"])?$_GET["name"]:'guest';
	  return ($arr);
	}
	
?>