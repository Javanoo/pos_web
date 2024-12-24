<?php
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
?>