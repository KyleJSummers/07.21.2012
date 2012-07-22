<?php

// auth.php

session_start();

if (isset($_GET['r']))
{
	$_SESSION['redirect'] = $_GET['r'];
}

if (!isset($_SERVER['REMOTE_USER']) && !isset($_SERVER['PHP_AUTH_USER']))
{
	header("Location: https://weblogin.umich.edu/?cosign-csg.umich.edu&https://csg.umich.edu/auth.php");
}
else {
	$user = isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] : $_SERVER['PHP_AUTH_USER'];
	$private_key = 'OrMXhb1jLJU8hGPLw3sQD4sgJMAFJvGu4xIa4SEp';

	$nonce = $_GET['n'];

	$auth_token = hash('sha256', $private_key . $user . strlen($user) . $nonce);

	header("Location: " . $_SESSION['redirect'] . "?u=" . $user . "&a=" . $auth_token);
}

?>