#!/bin/bash
cd "$(dirname "$0")"

# Load local environment file to load the localise.biz api key (LOCALISE_KEY)
. env.local

EN_MTIME=$(grep "Exported at:" community-obedience-en-AU.xlf | cut -d ':' -f 2-)
ZH_MTIME=$(grep "Exported at:" community-obedience-zh.xlf | cut -d ':' -f 2-)
KO_MTIME=$(grep "Exported at:" community-obedience-ko.xlf | cut -d ':' -f 2-)

curl -o 'community-obedience-en-AU.xlf' -z "$EN_MTIME" "https://localise.biz/api/export/locale/en-AU.xlf?index=text&fallback=en-AU&key=$LOCALISE_KEY&format=xlf2"
curl -o 'community-obedience-zh.xlf' -z "$ZH_MTIME" "https://localise.biz/api/export/locale/zh.xlf?index=text&key=$LOCALISE_KEY&format=xlf2&fallback=en-AU"
curl -o 'community-obedience-ko.xlf' -z "$KO_MTIME" "https://localise.biz/api/export/locale/ko.xlf?index=text&key=$LOCALISE_KEY&format=xlf2&fallback=en-AU"