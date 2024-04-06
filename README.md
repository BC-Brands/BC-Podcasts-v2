# BC-Podcasts-v2
BC Podcasts is an open-source podcast management platform.
We're making our source code from our 2021 (revised 2024) podcast management platform (https://host.bcwd.site/podcasts/) available for others to use, modify and remix.

BC Podcasts allows podcast makers to host their files on their own servers. They can then distribute these to popular podcast platforms, including our BC Podcasts directory.

## Setup
*The following setup has been tested for Ubuntu Server 18.04.5 LTS running Nginx on Microsoft Azure.*

1. Setup your server.
2. Clone a copy of this repository into the /var/www/html/ (or equivalent) directory.
3. Run `./setup.sh` to setup the software.
4. Open a browser and navigate to http(s)://[IP Address or Domain]/admin/ and complete the remainder of the setup process.
5. You're good to go!

## Creating a Podcast
Before you can start adding episodes, you need to create a podcast.

1. Visit http(s)://[IP Address or Domain]/admin/.
2/ Under 'Create a Podcast', fill out the podcast details.
3. Once you have clicked submit, the podcast will be created
4. Your podcast RSS feed will be located at /data/{name}/feed.rss. Do not use this RSS until you have added your first episode.

## Adding an episode
1. Visit your admin page on http(s)://[IP Address or Domain]/admin/.
2. Under 'Create a Podcast', click 'Go >>>'.
3. Fill out the podcast details and upload the file.
4. If everything is in order, your podcast will be uploaded to /files/[name].mp3.
5. Your RSS feed will also be automatically updated.
