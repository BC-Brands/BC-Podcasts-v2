<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BC Podcasts</title>
        <link rel="stylesheet" href="./assets/style.css">
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
            
            $env = loadCreds();

            $url = htmlspecialchars($_GET["podcast"]);

            $db = Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
            $podcast = $db->getPodcastInfo($url);

            $id = 0;

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
            if (count($podcast) == 0){
                echo "<p>No Episodes Found.</p>";
            } else {
                $episodes = $db->getEpisodes($id);


                for ($i = 0; $i < count($podcasts); $i++){
                    echo '<div class="podcast"><div class="pod_image">';
                    echo '<img src="' . $podcasts[$i]["image"] . '">';
                    echo '</div><div class="pod_info">';
                    echo '<h2><a href="">' . $podcasts[$i]["name"] . "</a></h2>";
                    echo "<p>" . $podcasts[$i]["description"] . "</p>";
                    echo "<audio controls>";
                    echo '<source src="' . $podcasts[$i]["audio"] . '" type="audio/mpeg">';
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