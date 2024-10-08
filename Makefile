SHELL = /bin/bash
.SHELLFLAGS = -o pipefail -c

modifieddate := $(shell date '+%Y-%m-%d %H:%M')

update-appcache:
	sed -i "/^# Version /c# Version $(modifieddate)" cache.appcache

all: update-appcache static

public: update-appcache
	rm -rf public/
	mkdir public
	cp -r images/ css/ bootstrap-3.1.1-dist/ js/ cache.appcache public/

static: public
	php index.php | ./node_modules/.bin/html-minifier-terser --collapse-whitespace \
	--remove-comments --remove-optional-tags --remove-redundant-attributes \
	--remove-tag-whitespace --minify-css true --minify-js true \
	> public/index.html
	

