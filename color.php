<?php

function http_response($ch, $url)
{
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	return $httpCode . ' - ' . $response;
}

$value = $_GET['value'];
echo $value;
if(!preg_match('![a-fA-F0-9]{6}!', $value)) {
	$value = 'ffffff';
	echo 'fail' . "\n";
}

$mode = $_GET['mode'];
if(!in_array($mode, ['s', 'y', 'f'])) {
	$mode = 's';
}

$stromstoss = $_GET['stromstoss'];
if(!$stromstoss==1) {
        $stromstoss = 0;
}

$red = hexdec(substr($value, 0, 2));
$green = hexdec(substr($value, 2, 2));
$blue = hexdec(substr($value, 4, 2));

$baseUrl = 'http://netio.chch.lan.ffc/ecmd?';
$url = $baseUrl . 'channel%20';

$ch = curl_init();

$step = intval($_GET['fadestep']);
if(is_int($step)) {
	echo http_response($ch, $baseUrl . 'fadestep' . '%20' . $step);
	echo "\n";
}

if($stromstoss==0) {
	$red=$red;
	$green=$green*200/255;
	$blue=$blue*128/255;
}

echo $url . '5' . '%20' . $red . '%20' . $mode . "\n";
echo http_response($ch, $url . '5' . '%20' . $red . '%20' . $mode);
echo "\n";
echo http_response($ch, $url . '4' . '%20' . $green . '%20' . $mode);
echo "\n";
echo http_response($ch, $url . '3' . '%20' . $blue . '%20' . $mode);
echo "\n";

curl_close($ch);


