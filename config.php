<?php
/*
HOW TO USE
Make sure savepages.php is run first of course, this will create the folders. Granted it wont be until it runs a second time that you can compare files.

Set a cron job to hit cleanup.php (this cleans up old files, so you dont waste space, as it might get big overtime), it only keeps the last 2 files.

Set a cron job to hit savepages.php (this grabs copies of the website so it can do a comparison)

NOTES
This isnt optimized for a ton of URLs, but since it uses copy(), it should be able to handle quite a bunch
This might eat up more memory than usual and take longer than usual.
*/

ini_set('max_execution_time', '1800');
ini_set('memory_limit', '256M');


//php 5.6+ allows constant arrays now, php7+ allows you to use define
const CONST_URLS_TO_CHECK = array(
//add URLS here
'http://example.com',
'http://example.com/blog',
);

define('CONST_PARENT_FOLDER', 'examplesite');//no seperators at front or end

//for PHPMailer, some settings are here
define('CONST_PHPMAILER_HOST', 'smtp.gmail.com');
define('CONST_PHPMAILER_HTML_EMAIL', true);//true or false
define('CONST_PHPMAILER_NAME', 'Change Reporter');
define('CONST_PHPMAILER_USERNAME', '@gmail.com');
define('CONST_PHPMAILER_PASSWORD', '');
define('CONST_PHPMAILER_RECIPIENT', '@gmail.com');
define('CONST_PHPMAILER_SMTPSECURE', 'tls');//tls or ssl
define('CONST_PHPMAILER_PORT', 587);