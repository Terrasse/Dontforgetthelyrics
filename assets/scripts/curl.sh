#!/bin/bash
if [ -f "application/logs/log_curl.php" ];then 
	`touch application/logs/log_curl.php`
fi
current_date=`date +%Y-%m-%d_%H:%M:%S`
echo "$current_date $1" >>application/logs/log_curl.php
curl -X GET "$1" -H "Accept: application/json" 2>log_curl.php