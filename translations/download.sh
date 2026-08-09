#!/bin/bash
set -euo pipefail
cd "$(dirname "$0")"

# Load local environment file to load the localise.biz api key (LOCALISE_KEY)
# In CI the key comes from the environment instead, so the file is optional
if [ -f env.local ]; then
    . env.local
fi

if ! command -v jq > /dev/null; then
    echo "jq is required to run this script" >&2
    exit 1
fi

# The locale list comes from locales.json, the single source of truth shared
# with index.php and app/index.ts
while IFS= read -r row; do
    localise_locale=$(jq -r '.value.localiseLocale' <<< "$row")
    xlf_file=$(jq -r '.value.xlfFile' <<< "$row")
    mtime=$(grep "Exported at:" "$xlf_file" | cut -d ':' -f 2- || true)

    curl_args=(-f -o "$xlf_file")
    if [ -n "$mtime" ]; then
        curl_args+=(-z "$mtime")
    fi
    curl "${curl_args[@]}" "https://localise.biz/api/export/locale/${localise_locale}.xlf?index=text&fallback=en-AU&key=${LOCALISE_KEY}&format=xlf2"
done < <(jq -c 'to_entries[]' locales.json)
