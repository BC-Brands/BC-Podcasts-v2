<?php
//Check if user is logged in (authentication required)
if ((isset($_SESSION["state"]) == false) || ($_SESSION["state"] != "active")) {
    header("Location: login.php");
}

$type = htmlspecialchars($_GET["type"]);
$id = htmlspecialchars($_GET["id"]);

require "../backend/database.php";
require "../backend/creds.php";

$env = loadCreds();

$db = new Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);

if ($type == "podcast"){
    //Get information from form
    $name = htmlspecialchars($_POST["name"]);
    $description = htmlspecialchars($_POST["description"]);
    $url = htmlspecialchars($_POST["url"]);
    $author = htmlspecialchars($_POST["author"]);

    $db->updatePodcast($id, $name, $description, $author, $url);
}

if ($type == "episode"){
    //Get information from form
    $name = htmlspecialchars($_POST["name"]);
    $description = htmlspecialchars($_POST["description"]);

    $db->updateEpisode($id, $name, $description);

    $url = $db->getPodcastURLFromEpisode($id);

    require "../backend/genRSS.php";

    //Update podcast RSS
    genRSS($url[0]);
}

?>