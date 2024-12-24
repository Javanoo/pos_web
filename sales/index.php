<?php
	$total = 0.0;
	$paid = 0.0;
	$change = 0.0;
	
	if(isset($_GET["history"])) {
		include 'history';
		exit;	
	}elseif(isset($_GET["logout"]) &&
				$_GET["logout"] == 'on') {
	}else {
		include 'sales.html';
		exit();	
	}
?>