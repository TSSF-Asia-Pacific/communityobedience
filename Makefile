modifieddate := $(shell date '+%Y-%m-%d %H:%M')

update-appcache:
	sed -i "/^# Version /c# Version $(modifieddate)" cache.appcache

all: update-appcache static

static:
	php index.php | ./node_modules/.bin/html-minifier --collapse-whitespace \
	--remove-comments --remove-optional-tags --remove-redundant-attributes \
	--remove-tag-whitespace --minify-css true --minify-js true \
	> index.html
	

