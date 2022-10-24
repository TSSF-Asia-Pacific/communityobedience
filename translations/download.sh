#!/bin/bash

# Load local environment file to load the localise.biz api key (LOCALISE_KEY)
. env.local
curl -o 'community-obedience-en-AU.xlf' "https://localise.biz/api/export/locale/en-AU.xlf?index=text&fallback=en-AU&key=$LOCALISE_KEY&format=xlf2"
curl -o 'community-obedience-zh.xlf' "https://localise.biz/api/export/locale/zh.xlf?index=text&key=$LOCALISE_KEY&format=xlf2&fallback=en-AU"
curl -o 'community-obedience-ko.xlf' "https://localise.biz/api/export/locale/ko.xlf?index=text&key=$LOCALISE_KEY&format=xlf2&fallback=en-AU"