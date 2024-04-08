<?php
require_once("database.php");
require_once("creds.php");

function genRSS($podcast_url){
    $env = loadCreds();

    $db = new Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
    $podcast = $db->getPodcastInfo($podcast_url);

    $episodes = $db->getEpisodes($podcast[0]["id"]);

    $feedURL = $env["fqdn"] . "/data/" . $podcast_url . "/feed.rss";

    //podcasts.id, podcasts.name, podcasts.author, podcasts.description

    $filepath =  __DIR__ . "/../data/" . $podcast_url . "/feed.rss";
    $dir = __DIR__ . "/../data/" . $podcast_url . "/";

    
    if (!file_exists($filepath)){
        mkdir($dir, 0755, true); 
        $file = fopen($filepath, "x");
        fclose($file);
    }

    $file = fopen($filepath, "w") or die("Unable to open file!");

    $fqdnURL = $env["fqdn"] . "/" . $podcast_url;
    $imageURL = $env["fqdn"] . $podcast[0]["image"];
    
    $currentDate = date("D, d M Y H:i:s O");

    $xml = <<<XML
    <?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:cc="http://web.resource.org/cc/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:media="http://search.yahoo.com/mrss/" xmlns:content="http://purl.org/rss/1.0/modules/content/"  xmlns:podcast="https://podcastindex.org/namespace/1.0"  xmlns:googleplay="http://www.google.com/schemas/play-podcasts/1.0" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
        <channel>
            <atom:link href="{$feedURL}" rel="self" type="application/rss+xml"/>
            <title>{$podcast[0]["name"]}</title>
            <pubDate>{$currentDate}</pubDate>
            <lastBuildDate>{$currentDate}</lastBuildDate>
            <generator>BC Podcasts</generator>
            <link>{$fqdnURL}</link>
            <language>en</language>
            <copyright><![CDATA[Copyright (C). All rights resevred.]]></copyright>
            <docs>{$fqdnURL}</docs>
            <managingEditor>{$podcast[0]["authorEmail"]}</managingEditor>
            <itunes:summary><![CDATA[{$podcast[0]["description"]}]]></itunes:summary>
            <image>
                <url>{$imageURL}</url>
                <title>{$podcast[0]["name"]}</title>
                <link><![CDATA[{$fqdnURL}]]></link>
            </image>
            <itunes:author>{$podcast[0]["author"]}</itunes:author>
            <itunes:keywords>podcast</itunes:keywords>
            <itunes:category text="Speech">
            </itunes:category>
            <itunes:image href="{$imageURL}" />
            <itunes:explicit>false</itunes:explicit>
            <itunes:owner>
                <itunes:name><![CDATA[{$podcast[0]["author"]}]]></itunes:name>
                <itunes:email>{$podcast[0]["authorEmail"]}</itunes:email>
            </itunes:owner>
            <description><![CDATA[{$podcast[0]["description"]}]]></description>
            <itunes:type>episodic</itunes:type>
            


            <podcast:locked owner="{$podcast[0]['authorEmail']}">no</podcast:locked>
XML;

    fwrite($file, $xml);

    /*
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    podcast INT(6) UNSIGNED,
                    name VARCHAR(50) NOT NULL,
                    description TEXT,
                    image TEXT,
                    published DATETIME,
                    audio TEXT
    */
    for ($i = 0; $i < count($episodes); $i++){
        $audio = rtrim($env["fqdn"], "/") . $episodes[$i]["audio"];
        $image = rtrim($env["fqdn"], "/") . $episodes[$i]["image"];

        sscanf($episodes[$i]["duration"], "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
        
        $episodeDate = date("D, d M Y H:i:s O", strtotime($episodes[$i]['published']));

        $item = <<<XML
                <item>
                    <title>{$episodes[$i]["name"]}</title>
                    <itunes:title>{$episodes[$i]["name"]}</itunes:title>
                    <pubDate>{$episodeDate}</pubDate>
                    <guid isPermaLink="false"><![CDATA[{$episodes[$i]["id"]}]]></guid>
                    <link><![CDATA[{$env['fqdn']}]]></link>
                    <itunes:image href="{$image}" />
                    <description><![CDATA[{$episodes[$i]["description"]}]]></description>
                    <content:encoded><![CDATA[{$episodes[$i]["description"]}]]></content:encoded>
                    <enclosure length="{$time_seconds}" type="audio/mpeg" url="{$audio}" />
                    <itunes:duration>{$episodes[$i]["duration"]}</itunes:duration>
                    <itunes:explicit>false</itunes:explicit>
                    <itunes:keywords>Podcast</itunes:keywords>
                    <itunes:subtitle><![CDATA[{$episodes[$i]["description"]}]]></itunes:subtitle>
                    <itunes:episodeType>full</itunes:episodeType>
                </item>
            </channel>
        </rss>
XML;
        fwrite($file, $item);
    }

    fclose($file);
}
?>