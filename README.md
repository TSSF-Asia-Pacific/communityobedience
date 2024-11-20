# TSSF Community Obedience
This web application is built to assist brothers and sisters of the Third Order of the Society of St. Francis (TSSF) with their Community Obedience Prayer. It is used on its own or in conjunction with morning or evening prayer.
If you see anything that needs fixing in the application or you are experiencing problems with the application please open a Github [issue](https://github.com/TSSF-Asia-Pacific/communityobedience/issues).

## How to add a translation

1. Add to Localise.biz
2. Update `translations/download.sh` to correctly download the file into a `community-obedience-en-AU.xlf` style file
3. Add a resource into the Translator component
   ```php
   $translator->addResource('xliff', './translations/community-obedience-en-AU.xlf', 'en');
   ```
4. Add an entry to the `$translations` array that maps between the button name key, and the correct date Locale
   ```php
        'zh-HK' => [
            'name' => 'Chinese (Traditional)',
            'dateLocale' => 'zh-hk'
        ],
   ```

# Development

## Test any day
2. Open your JS console in your browser 
   * Chrome - Press Command+Option+J (Mac) or Control+Shift+J (Windows, Linux, Chrome OS) to jump straight into the Console panel.
   * Firefox - Press the Ctrl+Shift+K (Command+Option+K on OS X) keyboard shortcut.
3. Run `display_obedience` with the date you wish to test. e.g.
   ```
   display_obedience(moment('2021-12-30'))
   ```
   
## Local Development
Using Docker and Docker Composer you can run a local webserver to test developemnt without static builds
1. Run `docker-compose up -d`
2. Access the site at http://localhost:8080. Reload the page in your browser to see your development changes
3. When finished, run `docker-compose rm -s` to stop and remove the containers


