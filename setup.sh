#!/bin/bash

# Set up directories for data
mkdir data
mkdir files

# Set Up Credentials
echo "== Database Setup =="
echo "1> Enter Database Username: "
read username
echo "2> Enter Database Password: "
read password
echo "3> Enter Database Name: "
read dbname
echo "4> Enter FQDN: "
read fqdn

servername="localhost"

echo "username::$username\npassword::$password\nservername::$servername\ndbname::$dbname\nfqdn::$fqdn" > './site/backend/credentials.env'

# Register software with BC Brands Software Centre
# Comment this step out if you do not wish to register
# (It is recommended that you register your software)
echo "== Software Registration =="
echo "Please provide an email for registration: "
read userEmail

ipaddr=$(ip route get 8.8.8.8 | grep -oP 'src \K[^ ]+')
path="https://host.bcwd.site/downloads/software/register.php?id=00003&ip=$ipaddr&email=$userEmail"

wget -O info.txt $path

echo "== Setup Complete ==";