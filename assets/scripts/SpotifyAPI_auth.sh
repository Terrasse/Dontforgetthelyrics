#!/bin/bash
if [ -f "application/logs/log_spotifyAPI_auth.php" ];then 
	`touch application/logs/log_spotifyAPI_auth.php`
fi
current_date=`date +%Y-%m-%d_%H:%M:%S`
echo "$current_date $1" >>application/logs/log_spotifyAPI_auth.php
curl -H "Authorization: Basic $2" -d grant_type=client_credentials $1