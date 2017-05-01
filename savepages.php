<?php
require_once('config.php');
require_once('functions.php');

//make sure this exists, if not create it
if (!is_dir(CONST_PARENT_FOLDER))
	mkdir(CONST_PARENT_FOLDER);

foreach(CONST_URLS_TO_CHECK as $url)
{
	$pagename = create_foldername($url);

	//if subfolder doesnt exist, create it
	if (!is_dir(CONST_PARENT_FOLDER . DIRECTORY_SEPARATOR . $pagename))
		mkdir(CONST_PARENT_FOLDER . DIRECTORY_SEPARATOR . $pagename);

	//file_put_contents or htmlentities was choking on the site, so using copy()
	copy(
		$url,
		CONST_PARENT_FOLDER . DIRECTORY_SEPARATOR . $pagename . DIRECTORY_SEPARATOR . date('mdYHis')
	);
}