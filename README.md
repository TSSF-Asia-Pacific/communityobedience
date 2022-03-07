# TSSF Community Obedience
This web application is built to assist brothers and sisters of the Third Order of the Society of St. Francis (TSSF) with their Community Obedience Prayer. It is used on its own or in conjunction with morning or evening prayer.
If you see anything that needs fixing in the application or you are experiencing problems with the application please open a Github [issue](https://github.com/TSSF-Asia-Pacific/communityobedience/issues).

## How to add a translation

1. Copy the en/ folder to a new folder with the correct 2 letter language code for the new language. e.g. ```fr/```

2. Update the language.php file in the new directory, and change the namespace from en to the 2 letter language code for the new language.
   ```php
   <?php
   namespace fr;
   
use languages\AbstractLanguage;
   
   class translation extends AbstractLanguage
   {
   ```

3. Update the variables in the language.php file to reflect the new language

4. Update the files in each of the subdirectories for the new language

5. Update index.php to load the new language, by adding a line that loads the new language into the languages array
   ```php
   // Load each translation into the translations array here
   $translations['en'] = new en\translation();
   $translations['fr'] = new fr\translation();
   ```

6. Update the cache.appcache file so the version comment line is up to date, otherwise your changes won't be seen
   ```
    # Version 2019-03-23 17:04
    ```

7. Submit a merge request to the master branch, once merged to master it'll be live!

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