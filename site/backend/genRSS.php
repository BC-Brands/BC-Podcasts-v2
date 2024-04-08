<?php
require "database.php";
require "creds.php";

function genRSS($podcast_url){
    $env = loadCreds();

    $db = new Database($env["username"], $env["password"], $env["servername"], $env["dbname"]);
    $podcast = $db->getPodcastInfo($podcast_url);

    $episodes = $db->getEpisodes($podcast[0]["id"]);

    $feedURL = $env["fqdn"] . "/data/" . $podcast_url . "/feed.rss";

    //podcasts.id, podcasts.name, podcasts.author, podcasts.description

    $filepath = "../data/" . $podcast_url . "/feed.rss";

    $file = fopen($filepath, "w") or die("Unable to open file!");

    $xml = <<<XML
    <?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:cc="http://web.resource.org/cc/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:media="http://search.yahoo.com/mrss/" xmlns:content="http://purl.org/rss/1.0/modules/content/"  xmlns:podcast="https://podcastindex.org/namespace/1.0"  xmlns:googleplay="http://www.google.com/schemas/play-podcasts/1.0" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
        <channel>
            <atom:link href="{$feedURL}" rel="self" type="application/rss+xml"/>
            <title>{$podcast[0]["name"]}</title>
            <pubDate>Tue, 08 Aug 2023 21:05:00 +0000</pubDate>
            <lastBuildDate>Wed, 03 Apr 2024 20:02:01 +0000</lastBuildDate>
            <generator>BC Podcasts</generator>
            <link>{$env["fqdn"] . "/" . $podcast_url}</link>
            <language>en</language>
            <copyright><![CDATA[Copyright (C). All rights resevred.]]></copyright>
            <docs>{$env["fqdn"] . "/" . $podcast_url}</docs>
            <managingEditor>{$podcast[0]["authorEmail"]}</managingEditor>
            <itunes:summary><![CDATA[{$podcast[0]["description"]}]]></itunes:summary>
            <image>
                <url>{$env["fqdn"] . $podcast[0]["image"]}</url>
                <title>{$podcast[0]["name"]}</title>
                <link><![CDATA[{$env["fqdn"] . "/" . $podcast_url}]]></link>
            </image>
            <itunes:author>{$podcast[0]["author"]}</itunes:author>
            <itunes:keywords>podcast</itunes:keywords>
            <itunes:category text="Speech">
            </itunes:category>
            <itunes:image href="{$env['fqdn'] . $podcast[0]['image']}" />
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
        $item = <<<XML
                <item>
                    <title>{$episodes[$i]["name"]}</title>
                    <itunes:title>{$episodes[$i]["name"]}</itunes:title>
                    <pubDate>{$episodes[$i]['published']}</pubDate>
                    <guid isPermaLink="false"><![CDATA[{$episodes[$i]["id"]}]]></guid>
                    <link><![CDATA[{$env['fqdn']}]]></link>
                    <itunes:image href="{$episodes[$i]['image']}" />
                    <description><![CDATA[{$episodes[$i]["description"]}]]></description>
                    <content:encoded><![CDATA[{$episodes[$i]["description"]}]]></content:encoded>
                    <enclosure length="101647475" type="audio/mpeg" url="{$env['fqdn'] . $episodes[$i]['audio']}" />
                    <itunes:duration>01:00:00</itunes:duration>
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