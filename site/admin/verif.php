<?php
require "../backend/creds.php";

ini_set('session.name', 'BCPodcasts');

$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

$env = loadCreds();

//Check if username and password match
if (($username == $env["username"]) and ($password == $env["password"])){
    //Set PHP session
    session_start();
    $_SESSION["state"] = "active";
    header("Location: home.php");
} else {
    header("Location: login.php");
}

?>