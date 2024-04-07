<?php
//Database class
class Database{
    private $username;
    private $password;
    private $servername;
    private $dbname;

    private $conn;

    function __constuct($username, $password, $servername, $dbname){
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
                audio TEXT
                )";

            $this->conn->exec($sql);
        } catch (PDOException $e){
            die("Error setting up database");
        }
    }

    function getPodcasts(){
        try{
            $stmt = $this->conn->prepare("SELECT podcasts.id, podcasts.name, podcasts.url, podcasts.author, podcasts.description, podcasts.image, episodes.name, episodes.audio FROM podcasts, episodes WHERE podcasts.latest = episodes.id");
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e){
            die("Error fetching data");
        }
    }
    function getPodcastInfo($url){
        try{
            $stmt = $this->conn->prepare("SELECT podcasts.id, podcasts.name, podcasts.author, podcasts.description FROM podcasts WHERE url = :url");
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
            $stmt = $this->conn->prepare("SELECT episodes.name, episodes.description, episodes.image, episodes.audio FROM podcasts, episodes WHERE episodes.podcast = podcasts.id AND podcasts.id = :id");
            $stmt->bindParam(":id", $podcast);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e){
            die("Error fetching data");
        }
    }
    function getAllEpisodes(){
        try{
            $stmt = $this->conn->prepare("SELECT episodes.id, episodes.name, episodes.published, podcasts.name, podcasts.url FROM podcasts, episodes WHERE episodes.podcast = podcasts.id");
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e){
            die("Error fetching data");
        }
    }
}
?>