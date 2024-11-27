<?php

session_start();

function senha_forte($senha)
{

	if (strlen($senha) < 8) {
		return false;
	}

	if (!preg_match("#[0-9]+#", $senha)) {
		return false;
	}

	if (!preg_match("#[a-z]+#", $senha)) {
		return false;
	}

	if (!preg_match("#[A-Z]+#", $senha)) {
		return false;
	}

	if (!preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $senha)) {
		return false;
	}

	return true;

}
function curl_get_file_contents($URL)
{
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_URL, $URL);
	$contents = curl_exec($c);
	curl_close($c);

	if ($contents) return $contents;
	else return FALSE;
}
