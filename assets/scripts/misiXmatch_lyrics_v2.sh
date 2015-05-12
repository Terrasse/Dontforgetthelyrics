# #!/bin/bash
if [ -f "application/logs/log_MisiXmatchAPI_lyrics_v2.php" ];then 
	`touch application/logs/log_MisiXmatchAPI_lyrics_v2.php`
fi

if [ -f "application/logs/log_MisiXmatchAPI_lyrics_v2_dl.php" ];then 
	`touch application/logs/log_MisiXmatchAPI_lyrics_v2_dl.php`
fi
current_date=`date +%Y-%m-%d_%H:%M:%S`
echo "current_date" >>application/logs/log_MisiXmatchAPI_lyrics_v2_dl.php
while [ $# -ge 1 ]; do
	echo " EOR "
	echo "$current_date $1" >>application/logs/log_MisiXmatchAPI_lyrics_v2.php
	curl -X GET $1 | sed -e '/<script>var __mxmProps/!d' -e 's/    <script>var __mxmProps = //g' -e 's/<\/script>//g' 2>>application/logs/log_MisiXmatchAPI_lyrics_v2_dl.php
	shift
done