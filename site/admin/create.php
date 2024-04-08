<?php
ini_set('session.name', 'BCPodcasts');
session_start();

//Check if user is logged in (authentication required)
if ((isset($_SESSION["state"]) == false) || ($_SESSION["state"] != "active")) {
    header("Location: login.php");
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
            <h1>Create</h1>
            <div>
                <button onclick="loadWindow('podcast');">Create Podcast</button>
                <button onclick="loadWindow('episode');">Create Episode</button>
            </div>
        </main>
        <div id="podcast">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <p>Podcast Name</p>
                <input type="text" name="name">
                <p>Podcast URL</p>
                <input type="text" name="url">
                <p>Podcast Author</p>
                <input type="text" name="author">
                <p>Podcast Description</p>
                <input type="text" name="description">
                <p>Podcast Image</p>
                <input type="file" name="image" />
                <br>
                <input type="submit" value="Create">
            </form>
        </div>
        <div id="episode">
            <form action="upload_episode.php" method="POST" enctype="multipart/form-data">
                <p>Podcast</p>
                <select name="podcast">
                    <option value="" disabled selected>-- Please Select --</option>
                    <?php
                    require "../backend/creds.php";
                    require "../backend/database.php";

                    $env = loadCreds();

                    //Get list of podcasts and their IDs
                    $db = new Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
                    $podcasts = $db->getPodcasts();

                    for ($i = 0; $i < count($podcasts); $i++){
                        echo "<option value='" . $podcasts[$i]["id"] . "'>" . $podcasts[$i]["name"] . "</option>";
                    }
                ?>
                </select>
                <p>Episode Name</p>
                <input type="text" name="name">
                <p>Episode Description</p>
                <input type="text" name="description">
                <p>Episode Image</p>
                <input type="file" name="image" />
                <p>Episode Audio</p>
                <input type="file" name="audio" />
                <p>Duration</p>
                <input type="text" name="duration">
                <br>
                <input type="submit" value="Create">
            </form>
        </div>
        <script>
            document.getElementById("episode").style.display = "none";

            function loadWindow(name){
                document.getElementById("episode").style.display = "none";
                document.getElementById("podcast").style.display = "none";

                document.getElementById(name).style.display = "block";
            }
        </script>
        <footer>
            <p>Powered by <a href="https://github.com/BC-Brands/BC-Podcasts-v2/">BC Podcasts</a></p>
        </footer>
    </body>
</html>