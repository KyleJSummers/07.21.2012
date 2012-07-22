<?php

// select-univ.php

session_start();

if ($_POST['univ'] == 'umich')
{
	$nonce = rand(9999, getrandmax());
	$_SESSION['nonce'] = $nonce;
	header("Location: https://csg.umich.edu/auth.php?r=http://kjsum.com/process-login.php&n=" . $nonce);
}

?>