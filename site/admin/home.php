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
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Test Podcast</td>
                    <td>BC Brands</td>
                    <td><a href="">View</a> | <a href="">Edit</a> | <a href="">Remove</a></td>
                </tr>
            </table>
        </div>
        <div id="episode">
            <button>New Episode</button>
            <hr>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Publish Date</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Test Podcast</td>
                    <td>BC Brands</td>
                    <td><a href="">View</a> | <a href="">Edit</a> | <a href="">Remove</a></td>
                </tr>
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