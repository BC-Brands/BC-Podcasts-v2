<?php
ini_set('session.name', 'BCPodcasts');
session_start();
                    
if ($_SESSION["state"] != "active") {
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
            <h1>BC Podcasts</h1>
            <p>Welcome to your self-hosting dashboard.</p>
            <div>
                <button onclick="loadWindow('podcast');">Manage Podcasts</button>
                <button onclick="loadWindow('episode');">Manage Episodes</button>
            </div>
        </main>
        <div id="podcast">
            <button>New Podcast</button>
            <hr>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Latest Episode</th>
                    <th>Actions</th>
                </tr>
                <?php
                require "../backend/creds.php";

                $env = loadCreds();

                $db = Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
                $podcasts = $db->getPodcasts();

                for ($i = 0; $i < count($podcasts); $i++){
                    echo "<tr>";
                    echo "<td>" . $podcasts[$i]["id"] . "</td>";
                    echo "<td>" . $podcasts[$i]["name"] . "</td>";
                    echo "<td>" . $podcasts[$i]["author"] . "</td>";
                    echo "<td>" . $podcasts[$i]["name"] . "</td>";
                    echo '<td><a href="../podcast/' . $podcasts[$i]["url"] . '">View</a> | <a href="./edit/podcast/' . $podcasts[$i]["id"] . '">Edit</a></td>';
                    echo "</tr>";
                }

                ?>
            </table>
        </div>
        <div id="episode">
            <button>New Episode</button>
            <hr>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Podcast</th>
                    <th>Name</th>
                    <th>Publish Date</th>
                    <th>Actions</th>
                </tr>
                <?php
                $episodes = $db->getAllEpisodes();

                for ($i = 0; $i < count($episodes); $i++){
                    echo "<tr>";
                    echo "<td>" . $episodes[$i]["id"] . "</td>";
                    echo "<td>" . $episodes[$i]["name"] . "</td>";
                    echo "<td>" . $episodes[$i]["epname"] . "</td>";
                    echo "<td>" . $episodes[$i]["published"] . "</td>";
                    echo '<td><a href="../podcast/' . $episodes[$i]["url"] . '">View</a> | <a href="./edit/episode/' . $episodes[$i]["id"] . '">Edit</a></td>';
                    echo "</tr>";
                }

                ?>
            </table>
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