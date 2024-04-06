<?php

function loadCreds(){
    $info = array(
        "username"=>"",
        "password"=>"",
        "servername"=>"",
        "dbname"=>""
    );

    $file = fopen("credentials.env", "r") or die("Unable to open file!");
    $contents = fread($file, filesize("credentials.env"));
    fclose($file);

    $lines = explode("\n", $contents);

    for ($i = 0; $i < count($lines); $i++){
        if ($lines[$i] != ""){
            $itemInfo = explode("::", $lines[$i]);
            $info[itemInfo[0]] = itemInfo[1];
        }
    }

    return $info;
}
?>