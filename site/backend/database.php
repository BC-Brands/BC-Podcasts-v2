<?php
//Database class
class Database{
    private $username;
    private $password;
    private $servername;
    private $dbname;

    private $conn;

    function __construct($username, $password, $servername, $dbname){
        $this->username = $username;
        $this->password = $password;
        $this->servername = $servername;
        $this->dbname = $dbname;

        //Create connection with Database
        try{
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            die("Connection with database failed");
        }
    }

    function __destruct(){
        $this->conn = null;
    }
    
    function createDB(){
        try{
            $sql = "CREATE TABLE podcasts (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                url VARCHAR(25) NOT NULL,
                author VARCHAR(50) NOT NULL,
                authorEmail VARCHAR(50),
                description TEXT,
                image TEXT,
                latest INT(6) UNSIGNED
                );
                CREATE TABLE episodes (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                podcast INT(6) UNSIGNED,
                name VARCHAR(50) NOT NULL,
                description TEXT,
                image TEXT,
                published DATETIME,
                audio TEXT,
                duration TIME
                )";

            $this->conn->exec($sql);
        } catch (PDOException $e){
            die("Error setting up database");
        }
    }

    function createPodcast($name, $url, $author, $description, $image){
        try {
            $stmt = $this->conn->prepare("INSERT INTO podcasts (name, url, author, description, image, latest) VALUES (:name, :url, :author, :description, :image, :latest");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":url", $url);
            $stmt->bindParam(":author", $author);
            $stmt->bindParam(":desctiption", $description);
            $stmt->bindParam(":image", $image);
            $stmt->bindParam(":latest", 0);
            $stmt->execute();
        } catch (PDOException $e){
            die("Error inserting data");
        }          
    }

    function createEpisode($podcast, $name, $description, $image, $audio, $duration){
        try{
            $stmt = $this->conn->prepare("INSERT INTO episodes (podcast, name, description, image, published, audio, duration) VALUES (:podcast, :name, :description, :image, NOW(), :audio, :duration)");
            $stmt->bindParam(":podcast", $podcast);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":image", $image);
            $stmt->bindParam(":audio", $audio);
            $stmt->bindParam(":duration", $duration);
            $stmt->execute();

            $last_id = $this->conn->lastInsertId();

            $stmt = $this->conn->prepare("UPDATE podcasts SET latest = :latest WHERE id = :podcast");
            $stmt->bindParam(":latest", $last_id);
            $stmt->bindParam(":podcast", $podcast);
            $stmt->execute();
        } catch (PDOException $e){
            die("Error inserting data");
        }
    }
    
    function updatePodcast($id, $name, $description, $author, $url){
        try{
            $stmt = $this->conn->prepare("UPDATE podcasts SET name = :name, description = :description, author = :author, url = :url WHERE id = :id");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":author", $author);
            $stmt->bindParam(":url", $url);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (PDOException $e){
            die("Error inserting data");
        }
    }

    function updateEpisode($id, $name, $description){
        try{
            $stmt = $this->conn->prepare("UPDATE episodes SET name = :name, description = :description WHERE id = :id");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (PDOException $e){
            die("Error inserting data");
        }
    }

    function getPodcasts(){
        try{
            $stmt = $this->conn->prepare("SELECT podcasts.id, podcasts.name, podcasts.url, podcasts.author, podcasts.description, podcasts.image, episodes.name AS epname, episodes.audio FROM podcasts, episodes WHERE podcasts.latest = episodes.id");
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e){
            die("Error fetching data");
        }
    }
    function getPodcastURL($id){
        try{
            $stmt = $this->conn->prepare("SELECT podcasts.url FROM podcasts WHERE podcasts.id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e){
            die("Error fetching data");
        }
    }
    function getPodcastURLFromEpisode($id){
        try{
            $stmt = $this->conn->prepare("SELECT podcasts.url FROM podcasts, episodes WHERE episodes.podcast = podcasts.id AND episodes.id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e){
            die("Error fetching data");
        }
    }
    function getPodcastInfo($url){
        try{
            $stmt = $this->conn->prepare("SELECT podcasts.id, podcasts.name, podcasts.author, podcasts.authorEmail, podcasts.description, podcasts.url, podcasts.image FROM podcasts WHERE url = :url");
            $stmt->bindParam(":url", $url);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e){
            die("Error fetching data");
        }
    }
    function getEpisodes($podcast){
        try{
            $stmt = $this->conn->prepare("SELECT episodes.id, episodes.name, episodes.description, episodes.image, episodes.audio, episodes.published, episodes.duration FROM podcasts, episodes WHERE episodes.podcast = podcasts.id AND podcasts.id = :id");
            $stmt->bindParam(":id", $podcast);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e){
            die("Error fetching data");
        }
    }
    function getEpisode($id){
        try{
            $stmt = $this->conn->prepare("SELECT episodes.name, episodes.description FROM episodes WHERE episodes.id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e){
            die("Error fetching data");
        }
    }
    function getAllEpisodes(){
        try{
            $stmt = $this->conn->prepare("SELECT episodes.id, episodes.name AS epname, episodes.published, podcasts.name, podcasts.url FROM podcasts, episodes WHERE episodes.podcast = podcasts.id");
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e){
            die("Error fetching data");
        }
    }
}
?>