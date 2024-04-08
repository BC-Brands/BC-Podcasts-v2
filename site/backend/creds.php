<?php

function loadCreds(){
    $info = array(
        "username"=>"",
        "password"=>"",
        "servername"=>"",
        "dbname"=>""
    );
    
    $fname =  __DIR__ . "/credentials.env";

    $file = fopen($fname, "r") or die("Unable to open file!");
    $contents = fread($file, filesize($fname));
    fclose($file);

    $lines = explode("\n", $contents);

    for ($i = 0; $i < count($lines); $i++){
        if ($lines[$i] != ""){
            $itemInfo = explode("::", $lines[$i]);
            $info[$itemInfo[0]] = trim($itemInfo[1]);
        }
    }

    return $info;
}
?>