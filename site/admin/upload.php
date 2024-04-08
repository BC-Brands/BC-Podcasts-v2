<?php
//Check if user is logged in (authentication required)
if ((isset($_SESSION["state"]) == false) || ($_SESSION["state"] != "active")) {
    header("Location: login.php");
}

//Upload Podcast

$name = htmlspecialchars($_POST["name"]);
$url = htmlspecialchars($_POST["url"]);
$author = htmlspecialchars($_POST["author"]);
$description = htmlspecialchars($_POST["description"]);

$fileField = "image";

/*File Upload Script

Please report any vulnerabilities immediately
to software@bcwd.site.

*/

//From <input type="file" name="upload" />

if (!isset($_FILES[$fileField])){
    die("There is no file to upload");
}

//Current (temp) filepath
$filepath = $_FILES[$fileField]["tmp_name"];

//Get the size
$filesize = filesize($filepath);

//Get file information
$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
$filetype = finfo_file($fileinfo, $filepath);

if ($filesize === 0){
    die("The file is empty.");
}

//Set the maximum file size at 200 MB
if ($filesize > (1 * 1024 * 1024 * 200)){
    die("The file is too large.");
}

//Allowed Types
$allowedTypes = [
    "audio/mpeg" => "mp3",
    "image/png" => "png",
    "image/jpeg" => "jpg"
];

if (!in_array($filetype, array_keys($allowedTypes))){
    die("File not allowed");
}

//Validation Complete, move the file into uoploads.
//Generate Random Filename
$filename = substr(base64_encode(sha256(mt_rand())), 0, 32);
$extension = $allowedTypes[$filetype];
$targetDirectory = __DIR__ . "/../files/";
$newFilepath = $targetDirectory . $filename . "." . $extension;

if (!move_uploaded_file($filepath, $newFilepath)){
    die("Can't move file");
}

//Remove Temp File
unlink($filepath);

echo "File Uploaded successfully.";

// Add Podcast
$imageName = "/files/" . $filename . "." . $extension;

require "../backend/creds.php";
require "../backend/database.php";

$env = loadCreds();

$db = new Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
$db->createPodcast($name, $url, $author, $description, $imageName);

header("Location: home.php");
?>