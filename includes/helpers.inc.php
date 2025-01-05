<?php 
//all template helper functions should be placed in here


/*
* all data entered by users should be sanitized.
* meaning to say, no input data from user should reach the server or 
* database without passing through this method, 
* the stored data should be a result of this method.
* NOTE: this applies to text data only.
*/
function sanitize($text){
	$sanitizedText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	return $sanitizedText;
}


/*
* Suppose an operation fails, this method should be called,
* with the error object so as the user gets the appropriate 
* error view and a proper log file gets generated. 
*/
function report_error($error){
	$error_report = $error->getMessage();
	header('Location: /pos_web/errors/?error="'."$error_report".'"');
	exit();
}

/*
* establishes a database connection.
* set the appropriate credentials.
*/
function connecttodb($host, $database, $user, $password){
	try{	
		$con = new PDO('mysql:host='.$host.';dbname='.$database, $user, $password);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$con->exec('SET NAMES "utf8"');
		return $con;
	}catch(PDOException $e){
		echo $e->getMessage();
		report_error($e);	
	}
}

//verifies credentials
//tries to avoid timing attacks
function authorise($con, $name, $password) {
	try{		
		$sql = 'SELECT name, password FROM clients WHERE name="'.$name.'"
				 AND password="'.md5($name.$password).'"';
		$count = 0;
		$result = $con->query($sql);
		$row = $result->fetch();		
		if($row != false && 
			$name == $row['name'] && 
			$row['password'] == md5($name.$password)) {
			return true;
		}
		else{
			echo "false : ".md5($name.$password); 
			return false;
		}
	}catch(PDOException $e){
		
	}	
}

/*
* redirects a user to a specified page based on the user's
* group.
* if it fails to do so because of database issues or something,
* user is sent back to the login page.
*/
function redirect_user($con, $name, $password) {
	try{
		//fetch user's group
		$sql = 'SELECT groupId FROM clients WHERE name="'.$name.'"
				 AND password="'.md5($name.$password).'"';
		$result = $con->query($sql);
		foreach($result as $record){
			$groupId = $record["groupId"] == null ? null : $record["groupId"]; 		
		}
		
		//redirect 
		switch($groupId) {
			case "admin" : {
				header('Location: admin/');
				break;				
			}
			case "cashier" : {
				header('Location: sales/');
				break;
			}
			default:{
				header('Location: ../pos_web');
				break;				
			}
		}			
	}catch(PDOException $e){
		report_error($e);
	}	
}
