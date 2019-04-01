# TSSF Community Obedience
This web application is built to assist brothers and sisters of the Third Order of the Society of St. Francis (TSSF) with their Community Obedience Prayer. It is used on its own or in conjunction with morning or evening prayer.
If you see anything that needs fixing in the application or you are experiencing problems with the application please open a Github [issue](https://github.com/TSSF-Asia-Pacific/communityobedience/issues).

## How to add a translation

1. Copy the en/ folder to a new folder with the correct 2 letter language code for the new language. e.g. ```fr/```

2. Update the language.php file in the new directory, and change the namespace from en to the 2 letter language code for the new language.
   ```php
   <?php
   namespace fr;
   
   use \language;
   
   class translation extends language
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
    
6. Submit a merge request to the master branch, once merged to master it'll be live!