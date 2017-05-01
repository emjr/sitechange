<?php
require_once('config.php');
require_once('functions.php');
require_once('library/class.Diff.php');// http://code.stephenmorley.org/php/diff-implementation/
require_once('library/PHPMailer/PHPMailerAutoload.php');// https://github.com/PHPMailer/PHPMailer
$data = '';
$debug = '';//store $html output, so we can echo this later

foreach(CONST_URLS_TO_CHECK as $url)
{
	$pagename = create_foldername($url);
	$folder = CONST_PARENT_FOLDER . DIRECTORY_SEPARATOR . $pagename;
	//STOPPED HERE

	$dir = scandir($folder);

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
				$files[] = $value;//storing them so we can sort based on time and compare data
				$lastmodified[] = filemtime($folder . DIRECTORY_SEPARATOR . $value);
			}
		}

		//if we have 2 files to compare
		if (count($files) > 1)
		{
			array_multisort($lastmodified, SORT_DESC, $files);

			$after = $folder . DIRECTORY_SEPARATOR . $files[0];//newest
			$before = $folder . DIRECTORY_SEPARATOR . $files[1];

			$diff = Diff::compareFiles($before, $after);

			$html .= "<h2>PAGE: $pagename</h2>";
			$text .= $pagename . "\r\n========================================\r\n";

			$count = count($diff);
			for($x = 0; $x < $count; $x++)
			{
				if ($diff[$x][1] != 0)
				{
					if ($diff[$x][1] == 1)
					{
						$data = htmlentities($diff[$x][0], ENT_QUOTES, 'UTF-8', false);
						$html .= '<h3>DELETED</h3>' . $data;
						$text .= "\r\n------------------------------\r\n" . "DELETED____________________\r\n" . $data;
					}
					else
					{
						$data = htmlentities($diff[$x][0], ENT_QUOTES, 'UTF-8', false);
						$html .= '<h3>INSERTED</h3>' . $data;
						$text .= "\r\n------------------------------\r\n" . "INSERTED____________________\r\n" . $data;
					}
				}
			}

			$html .= '<hr>';
			$text .= "\r\n------------------------------\r\n" . "\r\n------------------------------\r\n";
			$debug .= $html;

			//EMAIL
			$mail = new PHPMailer;
			//$mail->SMTPDebug = 3;// Enable verbose debug output

			$mail->isSMTP();
			$mail->Host = CONST_PHPMAILER_HOST;
			$mail->SMTPAuth = true;
			$mail->Username = CONST_PHPMAILER_USERNAME;
			$mail->Password = CONST_PHPMAILER_PASSWORD;
			$mail->SMTPSecure = CONST_PHPMAILER_SMTPSECURE;
			$mail->Port = CONST_PHPMAILER_PORT;
			$mail->setFrom(CONST_PHPMAILER_USERNAME, CONST_PHPMAILER_NAME);
			$mail->addAddress(CONST_PHPMAILER_USERNAME);
			$mail->isHTML(CONST_PHPMAILER_HTML_EMAIL);//html email

			$mail->Subject = 'Web Changes-' . $pagename;

			if (CONST_PHPMAILER_HTML_EMAIL)
				$mail->Body = $html;//HTML body
			else
				$mail->AltBody = $text;//plain text body for non-HTML

			if(!$mail->send())
			{
				echo '<h1>Message could not be sent.</h1>';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			}
			else
			{
				echo '<h1>Message has been sent</h1>';
			}
			
			unset($mail);//clear it
		}
	}
	//exit();//DEBUG

	//reset
	$html = '';
	$text = '';
}