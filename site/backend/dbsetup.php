<?php
require "database.php";
require "creds.php";

$env = loadCreds();

//Create Database Tables
$db = new Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
$db->createDB();

echo "Done";
?>