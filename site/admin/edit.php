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
        <p>Coming Soon!</p>
        <footer>
            <p>Powered by <a href="https://github.com/BC-Brands/BC-Podcasts-v2/">BC Podcasts</a></p>
        </footer>
    </body>
</html>