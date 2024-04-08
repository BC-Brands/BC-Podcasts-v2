<?php
$type = htmlspecialchars($_GET["type"]);
$id = htmlspecialchars($_GET["id"]);

require "../backend/database.php";
$env = loadCreds();

$db = Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);

if ($type == "podcast"){
    $name = htmlspecialchars($_POST["name"]);
    $description = htmlspecialchars($_POST["description"]);
    $url = htmlspecialchars($_POST["url"]);
    $author = htmlspecialchars($_POST["author"]);

    $db->updatePodcast($id, $name, $description, $author, $url);
}

if ($type == "episode"){
    $name = htmlspecialchars($_POST["name"]);
    $description = htmlspecialchars($_POST["description"]);

    $db->updateEpisode($id, $name, $description);

    $url = $db->getPodcastURLFromEpisode($id);

    require "../backend/genRSS.php";

    genRSS($url[0]);
}

?>