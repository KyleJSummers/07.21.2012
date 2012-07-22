<?php

session_start();

$user = $_GET['u'];

if( !isset($_SESSION['nonce']) )
{
	die("Expired authentication.");
}

$nonce = $_SESSION['nonce'];
unset($_SESSION['nonce']);
$private_key = 'OrMXhb1jLJU8hGPLw3sQD4sgJMAFJvGu4xIa4SEp';

if($_GET['a'] != hash('sha256', $private_key . $user . strlen($user) . $nonce)) {
	die("Invalid authentication.");
}
else {
	$_SESSION['user'] = $user;
	header("Location: oh.php");
}

?>