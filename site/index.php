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
            <h1>My Podcasts</h1>
            <p>Hey! I'm self-hosting my podcast using BC Podcasts!</p>
        </main>
        <div class="pod_box">
            <?php
            //Dynamically Populate Page 
            require "./backend/creds.php";
            
            $env = loadCreds();

            $db = Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
            $podcasts = $db->getPodcasts();

            for ($i = 0; $i < count($podcasts); $i++){
                echo '<div class="podcast"><div class="pod_image">';
                echo '<img src="' . $podcasts[$i]["image"] . '">';
                echo '</div><div class="pod_info">';
                echo '<h2><a href="">' . $podcasts[$i]["name"] . "</a></h2>";
                echo '<p>' . $podcasts[$i]["author"] . "</p>";
                echo "<p>" . $podcasts[$i]["description"] . "</p>";
                echo "<hr>";
                echo "<p><b>Latest Episode</b></p>";
                echo "<p>" . $podcasts[$i]["name"] . "</p>";
                echo "<audio controls>";
                echo '<source src="' . $podcasts[$i]["audio"] . '" type="audio/mpeg">';
                echo "</audio>";
                echo "</div></div>";
            }

            ?>
        </div>
        <footer>
            <p>Powered by <a href="https://github.com/BC-Brands/BC-Podcasts-v2/">BC Podcasts</a></p>
        </footer>
    </body>
</html>