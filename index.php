<?php
	//include files
	require 'includes/helpers.inc.php';
	$con = connecttodb("localhost", "pos_shop", "root", "roots.5");
	
	//get credentials
	$name = isset($_POST["name"]) ? sanitize($_POST["name"]) : null;
	$password = isset($_POST["password"]) ? sanitize($_POST["password"]) : null;
	$password_hash = isset($_SESSION["password_hash"]) ? $_SESSION["password_hash"] : null;
	
	/*
	* check if user already logged in, if so, redirect with no authentication.
	* if not, authenticate and redirect.
	* if the user isn't logged in and authentication has failed as well,
	* prompt for user credentials.
	*/
	if($password_hash == md5($name.$password)) {
		//redirect user to the appropriate site
		redirect_user($con, $name,$password);
		exit();	
	}elseif(((isset($_POST["name"])) && (isset($_POST["password"]))) &&
			authorise($con, $name, $password)) {
		//initiate a session and 
		//redirect user to the appropriate page
		session_start();
		$_SESSION["password_hash"] = md5($name.$password);
		redirect_user($con, $name, $password);
		exit();
	}else{
		include 'login.html';
		exit();	
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
			$sql = 'SELECT groupId FROM users WHERE name="'.$name.'"
					 AND password="'.md5($name.$password).'"';
			$result = $con->exec($sql);
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
			//report_error($e);
		}	
	}
	
	//verifies credentials
	//tries to avoid timing attacks
	function authorise($con, $name, $password) {
		$sql = 'SELECT COUNT(*) FROM users WHERE name="'.$name.'"
				 AND password="'.md5($name.$password).'"';
		$count = 0;
		$count = $con->exec($sql);
		if($count == 1) return true;
		else return false;	
	}
	
?>