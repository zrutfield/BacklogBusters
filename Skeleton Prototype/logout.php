<?php 
	require_once("header.php");
    if(isset($_SESSION['userid']))
    {
        // Destroy session cookies on logout
        session_destroy();
        $redirect_uri = 'index.php';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    } 
    else 
    {
        print 'ERROR: NO USER LOGGED IN';
    }
?>

