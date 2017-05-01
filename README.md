# sitechange
Download archives of a website and then compare the differences. Diff for a website.

HOW TO USE
Make sure savepages.php is run first of course, this will create the folders. Granted it wont be until it runs a second time that you can compare files.

Set a cron job to hit cleanup.php (this cleans up old files, so you dont waste space, as it might get big overtime), it only keeps the last 2 files.

Set a cron job to hit savepages.php (this grabs copies of the website so it can do a comparison)

NOTES
This isnt optimized for a ton of URLs, but since it uses copy(), it should be able to handle quite a bunch
This might eat up more memory than usual and take longer than usual.
