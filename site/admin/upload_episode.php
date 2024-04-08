<?php
//Upload Episode

<p>Podcast</p>
<select name="podcast">
    <option value=""></option>
</select>
<p>Episode Name</p>
<input type="text" name="name">
<p>Episode Description</p>
<input type="text" name="description">
<p>Episode Image</p>
<input type="file" name="image" />
<p>Episode Audio</p>
<input type="file" name="audio" />

$podcast = intval(htmlspecialchars($_POST["podcast"]));
$name = htmlspecialchars($_POST["name"]);
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
$targetDirectory = __DIR__ . "../files/";
$newFilepath = $targetDirectory . $filename . "." . $extension;

if (!move_uploaded_file($filepath, $targetDirectory)){
    die("Can't move file");
}

//Remove Temp File
unlink($filepath);

echo "File Uploaded successfully.";

$imageName = "/files/" . $filename . "." . $extension;

$fileField = "audio";

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
$targetDirectory = __DIR__ . "../files/";
$newFilepath = $targetDirectory . $filename . "." . $extension;

if (!move_uploaded_file($filepath, $targetDirectory)){
    die("Can't move file");
}

//Remove Temp File
unlink($filepath);

echo "File Uploaded successfully.";

// Add Podcast
$audioName = "/files/" . $filename . "." . $extension;

require "../backend/creds.php";

$env = loadCreds();

$db = Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
$db->createEpisode($podcast, $name, $description, $imageName, $audioName);
$url = $db->getPodcastURL($podcast);

require "../backend/genRSS.php";

genRSS($url[0]);

header("Location: home.php");
?>