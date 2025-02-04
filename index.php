<?php
  session_start();
	//include files
	require 'includes/helpers.inc.php';
	$con = connecttodb("localhost", "pos_shop", "root", "");
	
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
	if(isset($password_hash)) {
		//redirect user to the appropriate site
		redirect_loggedin_user($con, $password_hash);
		exit();	
	}elseif(((isset($_POST["name"])) && (isset($_POST["password"]))) &&
			authorise($con, $name, $password)) {
		//initiate a session and 
		//redirect user to the appropriate page
		$_SESSION["password_hash"] = md5($name.$password);
		$_SESSION['username'] = sanitize($name);
		$_SESSION['user_id'] = 0;
		redirect_user($con, $name, $password);
		exit();
	}else{
		include 'login.html';
		exit();	
	}
?>