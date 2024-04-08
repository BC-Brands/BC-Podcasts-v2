<?php
ini_set('session.name', 'BCPodcasts');
session_start();
                    
if ($_SESSION["state"] != "active") {
    header("Location: login.php");
}

if (isset($_GET["type"])){
    $type = htmlspecialchars($_GET["type"]);
} else {
    header("Location: home.php");
}

if (isset($_GET["id"])){
    $id = htmlspecialchars($_GET["id"]);
} else {
    header("Location: home.php");
}

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BC Podcasts</title>
        <link rel="stylesheet" href="../assets/style.css">
    </head>
    <body>
        <header>
            <h2>Podcasts Admin</h2>
            <nav>
                <p>Home</p>
            </nav>
        </header>
        <main>
            <h1>Edit</h1>
        </main>
        <?php
        require "../backend/creds.php";
        require "../backend/database.php";

        $env = loadCreds();

        $db = new Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);

        if ($type == "podcast"){
            $url = $db->getPodcastURL($id);
            $podcasts = $db->getPodcast($url[0]);
            
            $form = <<<FORM 
            <div id="podcast">
                <form action="update.php?type=podcast&id={$id}" method="POST">
                    <p>Podcast Name</p>
                    <input type="text" name="name" value="{$podcasts[0]["name"]}">
                    <p>Podcast URL</p>
                    <input type="text" name="url" value="{$podcasts[0]["url"]}">
                    <p>Podcast Author</p>
                    <input type="text" name="author" value="{$podcasts[0]["author"]}">
                    <p>Podcast Description</p>
                    <input type="text" name="description" value="{$podcasts[0]["description"]}">
                    <br>
                    <input type="submit" value="Update">
                </form>
            </div>
            FORM;

            echo $form;
        }
        if ($type == "episode"){
            $episode = $db->getEpisode($id);

            $form = <<<FORM
            <div id="episode">
                <form action="update.php?type=episode&id={$id}" method="POST">
                    <p>Episode Name</p>
                    <input type="text" name="name" value="{$episode['name']}">
                    <p>Episode Description</p>
                    <input type="text" name="description" value="{$episode['description']}">
                    <br>
                    <input type="submit" value="Update">
                </form>
            </div>
            FORM;

            echo $form;
        }
        ?>
        <footer>
            <p>Powered by <a href="https://github.com/BC-Brands/BC-Podcasts-v2/">BC Podcasts</a></p>
        </footer>
    </body>
</html>