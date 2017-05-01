<?php
function create_foldername($url)
{
	$dir = preg_replace('#^http(s)?:\/\/[^\/]+#i', '', $url);//remove everything to the next first real / (removes protocol, domain and tld)
	$dir = preg_replace('/(\.|#).*/', '', $dir);//remove anything after period or octothorp - removes any extensions or anchor link
	$dir = substr(preg_replace('/[^a-zA-Z0-9\-_]/', '', $dir), 0, 128);//create a friendly foldername, could use 255 char limit, but lets be more sane

	if ($dir == '')
		$dir = 'index';

	return $dir;
}