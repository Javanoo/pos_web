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
	echo $error->getMessage();
	header('Location: errors/?error="'.$error_report.'"');
	exit();
}

/*
* establishes a database connection.
* set the appropriate credentials.
*/
function connecttodb($host, $database, $user, $password){
	try{	
		$con = new PDO('mysqlhost='.$host.';dbname='.$database, $user, $password);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$con->exec('SET NAMES "utf8"');
	}catch(PDOException $e){
		
		echo $e->getMessage();
		//report_error($e);	
	}
}