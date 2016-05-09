<?php

if($argv[1] !== NULL){

	$gov = $argv[1];
	
	$agent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.75 Safari/537.36";
	
	$ch = curl_init($gov);
	
	curl_setopt($ch, CURLOPT_NOBODY, true);
	//curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	curl_setopt($ch, CURLOPT_VERBOSE, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_exec($ch);
	
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	if($code === 200){
		echo $gov."\n";
		$fp = fopen("govs.txt", "a");
		fwrite($fp, $gov."\n");
		fclose($fp);
	}
}
