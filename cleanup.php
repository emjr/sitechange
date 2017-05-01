<?php
require_once('config.php');
require_once('functions.php');



foreach(CONST_URLS_TO_CHECK as $url)
{
	$filepath = CONST_PARENT_FOLDER . DIRECTORY_SEPARATOR . create_foldername($url);

	$dir = scandir($filepath);

	if ($dir !== false)
	{
		$files = array();//store files
		$lastmodified = array();

		//go through directory
		foreach ($dir as $key => $value)
		{
			//if its not a directory
			if (!is_dir($value))
			{
				$files[] = $value;//storing them so we dont have to ignore them later and so they are same length
				$lastmodified[] = filemtime($filepath . DIRECTORY_SEPARATOR . $value);
			}
		}

		array_multisort($lastmodified, SORT_DESC, $files);

		//if we have more than 2 files, we need to delete the others
		if (count($files) > 2)
		{
			//so we keep the 2 newest
			array_shift($files);
			array_shift($files);

			//now lets delete the other ones
			foreach ($files as $key => $value)
			{
				unlink($filepath . DIRECTORY_SEPARATOR . $value);
			}
		}
	}
}