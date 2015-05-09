!/bin/bash
if [ -f "application/logs/log_spotifyAPI_get.php" ];then 
	`touch application/logs/log_spotifyAPI_lyrics.php`
fi

if [ -f "application/logs/log_spotifyAPI_lyrics_dl.php" ];then 
	`touch application/logs/log_spotifyAPI_lyrics_dl.php`
fi
current_date=`date +%Y-%m-%d_%H:%M:%S`
echo "$current_date $1" >>application/logs/log_spotifyAPI_lyrics.php
echo "current_date" >>application/logs/log_spotifyAPI_lyrics_dl.php
curl -X GET "$1" | sed ':a;N;$!ba;s/\n//g' | sed -e 's/^.*\(<span id="line-0">\)/<br>\1/g' | sed  -e 's/<\/span>/\n/g' | sed -e '/^<i/d' | grep "line" | sed -e 's/^.*>//g' | sed ':a;N;$!ba;s/\n/<br>/g' 2>>application/logs/log_spotifyAPI_lyrics_dl.php