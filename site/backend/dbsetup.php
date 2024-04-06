<?php
require "database.php";
require "creds.php";

$env = loadCreds();

$db = Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
$db->createDB();

echo "Done";
?>