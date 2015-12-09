<?php 

class UserManager {
	protected $_db;

	public function __construct()
	{
		$this->_db = new Db();
	}

  public function authenticate($email, $pass){
        
      
    
      $email = $this->_db -> quote($email);

      $results = $this->_db -> select("SELECT * from users where email = $email limit 1");
      
      if(!$results){
        return FALSE;
      }
      
      foreach($results as $result){
        $user = new User();
        $user->hydrate($result);
      }
      
      //if(password_verify($pass, $user->getPassword())){
      if ($pass == $user->getPassword())
        return $user;

      else 
        return FALSE;
   

    
  }
  
  public function getAllRoles(){
    
      $roles = array();
          
      $roles = $this->_db -> select("SELECT * from roles order by sort_order asc");
            
      return $roles;    
      
  }
    	
  public function getUserById($userId){
    
    if(!is_numeric($userId)) return FALSE; 
    
      $uid = $this->_db -> quote($userId);
      $results = $this->_db -> select("SELECT * from users where uid = $uid limit 1");
      
      foreach($results as $result){
        $user = new User();
        $user->hydrate($result);
      }
      
      return $user;
    
  }

  public function getUserByEmail($email)
  {
  	$user = FALSE;
    try
    {
      $email= $this->_db -> quote($email);
      $results = $this->_db -> select("SELECT * from users where email = $email limit 1");
      $err = $this->_db->error();
	    if (!empty($err)) 
	    	throw new Exception("user select by email ($email) failed: ".$err);
	    	     
      foreach($results as $result){
        $user = new User();
        $user->hydrate($result);
      }

    }
    catch   (Exception $e) 
		{
    	error_log( 'Caught exception: '.  $e->getMessage() );
		} 
		     
    return $user;
    
  }
 
 
  public function getAllUsers(){
    
      $users = array();
          
      $results = $this->_db -> select("SELECT * from users");
      
    foreach($results as $result){
        $user = new User();
        $user->hydrate($result);
        $users[] = $user;
      }
            
      return $users;    
      
  }

  public function exportUsers(){
    
    
    $users = array();
        
    $results = $this->_db -> select("SELECT * from users");
      
    foreach($results as $result){
        $user = new User();
        $user->hydrate($result);
        $users[] = $user;
      }
            
      return $users;    
      
  }

	public function getUserId($email)
	{
		//input: User email string
   try
  	{
	    $userId = $this->_db -> query("select id from users where email= $email;");
	    
	    // test for error conditions
      $err = $this->_db->error();
	    if (!empty($err)) 
	    	throw new Exception("user insert failed: ".$err);
	    
	    return $userId;	
    }
    catch   (Exception $e) 
		{
    	error_log( 'Caught exception: '.  $e->getMessage() );
		}    
		
		return false;  
		
	}

  public function save($user){

     try
  	{
			if (null != $user->getId()) 
			{
      	$this->_update($user);
    	} 
    	else 
    	{
    		//ensure email is not duplicate since this is 
    		//  also the user login name
    		$id = $this->getUserId($user->getMail());
    		if (FALSE == $id) 
      		{$this->_add($user);}
      	else
      		{throw new Exception("user alrady exists (email=".$user->getMail());}
      		
    	}
    }
    catch   (Exception $e) 
		{
    	error_log( 'Caught exception: '.  $e->getMessage() );
		} 
  }

  public function update($user){
    
    //if ($user->getId()) {
    if ($user->getMail()) {
      $this->_update($user);
    } else {
      $this->_add($user);
    }
  }
  
  private function _add($user){
    
    $name = $this->_db -> quote($user->getName());
    $email = $this->_db -> quote($user->getMail());
    $role = $this->_db -> quote($user->getRole());
    $pass = $this->_db->quoteOrNull($user->getPassword());
    //$pass = password_hash($user->getPassword(), PASSWORD_BCRYPT); //, array("cost" => 10));
    //$pass = $this->_db -> quote($pass);
    
    try
  	{
  		
	    $results = $this->_db -> query("insert into users (name, email, pass, role) values ($name, $email, $pass, $role);");
	    
	    // test for error conditions
      $err = $this->_db->error();
	    if (!empty($err)) 
	    	throw new Exception("user insert failed: ".$err);
    }
    catch   (Exception $e) 
		{
    	error_log( 'Caught exception: '.  $e->getMessage() );
		}      

  }
  

  private function _update($user){
    $db = new Db();
    
    $uid = $db -> quote($user->getId());
    $name = $db -> quote($user->getName());
    $mail = $db -> quote($user->getMail());
    $role = $db -> quote($user->getRole());
    
    if($user->getPassword()){
      $pass = password_hash($user->getPassword(), PASSWORD_BCRYPT, array("cost" => 10));
      $pass = $db -> quote($pass);
      //$pass = $db -> quote($user->getPassword());
    } else {
      $pass = '';
    }

    if(!empty($pass)){
      $results = $db -> query("update users set name=$name, pass=$pass, email=$mail, role=$role where uid = $uid;");  
    } else {
      $results = $db -> query("update users set name=$name, email=$mail, role=$role where uid = $uid;");
    }

  }
  
  public function Delete($arg){
    
    if(!is_numeric($arg)) return FALSE;
    
      $db = new Db();
    
      $uid = $db -> quote($arg);
      $results = $db -> query("DELETE from users where uid = $uid");
  }
  
}

