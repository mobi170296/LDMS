<?php
	session_start();
	unset($_SESSION['maso']);
	unset($_SESSION['matkhau']);
	header('location: /');
?>