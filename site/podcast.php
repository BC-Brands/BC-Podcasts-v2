<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BC Podcasts</title>
        <link rel="stylesheet" href="../assets/style.css">
    </head>
    <body>
        <header>
            <h2>Podcasts</h2>
            <nav>
                <p>Admin Login</p>
            </nav>
        </header>
        <main>
            <?php
            //Dynamically Populate Page 
            require "./backend/creds.php";
            require "./backend/database.php";
            
            $env = loadCreds();

            $url = htmlspecialchars($_GET["podcast"]);

            //Display podcast information
            $db = new Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
            $podcast = $db->getPodcastInfo($url);

            $id = $podcast[0]["id"];

            if (count($podcast) == 0){
                echo "<h1>404 Error</h1>";
                echo "<p>No Podcast Found.</p>";
            } else {
                echo "<h1>" . $podcast[0]["name"] . "</h1>";
                echo "<p>" . $podcast[0]["author"] . "</p>";
                echo "<p>" . $podcast[0]["description"] . "</p>";

                $id = $podcast[0]["id"];
            }

            ?>
        </main>
        <div class="pod_box">
            <?php
            $episodes = $db->getEpisodes($id);

            //Display list of episodes
            if (count($episodes) == 0){
                echo "<p>No Episodes Found.</p>";
            } else {
                for ($i = 0; $i < count($episodes); $i++){
                    echo '<div class="podcast"><div class="pod_image">';
                    echo '<img src="' . rtrim($env["fqdn"], "/") . $episodes[$i]["image"] . '">';
                    echo '</div><div class="pod_info">';
                    echo '<h2><a href="">' . $episodes[$i]["name"] . "</a></h2>";
                    echo "<p>" . $episodes[$i]["description"] . "</p>";
                    echo "<audio controls>";
                    echo '<source src="' . rtrim($env["fqdn"], "/") . $episodes[$i]["audio"] . '" type="audio/mpeg">';
                    echo "</audio>";
                    echo "</div></div>";
                }
            }

            ?>
        </div>
        <footer>
            <p>Powered by <a href="https://github.com/BC-Brands/BC-Podcasts-v2/">BC Podcasts</a></p>
        </footer>
    </body>
</html>