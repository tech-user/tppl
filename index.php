<?php
	if (!empty($_SERVER['HTTP']) && ('on' == $_SERVER['HTTP'])) {
		$uri = 'http://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: login3.php');
	exit;
?>
