<?php

class Checar{
	public $url;
	
	public function __construct($url){
		$this->url = $url;
	}
	public function run(){
		if($url !== NULL) echo($this->url);
	}
}

$path = "";
$output = "";

$brasil = file_get_contents("https://gist.githubusercontent.com/letanure/3012978/raw/36fc21d9e2fc45c078e0e0e07cce3c81965db8f9/estados-cidades.json");
$brasil = json_decode($brasil, true);

$estados = count($brasil["estados"]);

$acentos = array('á' => 'a', 'à' => 'a', 'ã' => 'a',
     'â' => 'a', 'é' => 'e', 'ê' => 'e', 'í' => 'i',
     'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ú' => 'u',
     'ü' => 'u', 'ç' => 'c', 'Á' => 'a', 'À' => 'a',
     'Ã' => 'a', 'Â' => 'a', 'É' => 'e', 'Ê' => 'e',
     'Í' => 'i', 'Ó' => 'o', 'Ô' => 'o', 'Õ' => 'o',
     'Ú' => 'u', 'Ü' => 'u', 'Ç' => 'c', ' ' => '' ,
     '\''=> '' , '-' => '');
     
$sub[0] = "pc";
$sub[1] = "pm";
$sub[2] = "portal";
$sub[3] = "gcm";
$sub[4] = "gcmc";
$sub[5] = "policiacivil";
$sub[6] = "policiamilitar";
$sub[7] = "gcm";
$sub[8] = "camara";
$sub[9] = "prefeitura";

$gov[0] = "http://www.";
$gov[1] = "";


for($a = 0; $a < $estados; ++$a){
	$estado = strtolower($brasil["estados"][$a]["sigla"]);
	$cidades = count($brasil["estados"][$a]["cidade"]);
	
	for($b = 0; $b < $cidades; ++$b){
		$cidade = strtolower($brasil["estados"][$a]["cidades"][$b]);
		$cidade = strtr($cidade, $acentos);
		$gov[1] = $cidade;
		
		$governo[] = new Checar($gov[0].$gov[1].$gov[2]);
		
		/*
		for($c = 0; $c < count($sub); ++$c){
			$governo[1] = new Checar($gov[0].$sub[$c].$gov[2]);
			$governo[2] = new Checar($gov[0].$sub[$c].".".$gov[1].$gov[2]);
		}*/
		
	}
}

	var_dump($governo);
/*
$outro = false;

for($i = 0; $i < $estados; ++$i){
	$estado = strtolower($brasil["estados"][$i]["sigla"]);
	$cidades = count($brasil["estados"][$i]["cidades"]);
	$gov[2] = ".$estado.gov.br/";
	
	for($b = 0; $b < $cidades; ++$b){
		$cidade = strtolower($brasil["estados"][$i]["cidades"][$b]);
		$cidade = strtr($cidade, $acentos);
		$gov[1] = $cidade;
		echo $b." ";
		//check($gov[0].$gov[1].$gov[2]);
	}
	
	for($b = 0; $b < $cidades; ++$b){
		$cidade = strtolower($brasil["estados"][$i]["cidades"][$b]);
		$cidade = strtr($cidade, $acentos);
		$gov[1] = $cidade;
		echo $b."<br>";
		//check($gov[0].$gov[1].$gov[2]);
	}
	
	if(!($i === ($estados - 1))){
		$outro = true;	
	}
}

for($i = 0; $i < $estados; ++$i){
	$estado = strtolower($brasil["estados"][$i]["sigla"]);
	$cidades = count($brasil["estados"][$i]["cidades"]);
	echo $cidades."\n\n";
	/*
	$gov[2] = ".$estado.gov.br/";
	
	for($a = 0; $a < $cidades; ++$b){
		$cidade = strtolower($brasil["estados"][$i]["cidades"][$b]);
		$cidade = strtr($cidade, $acentos);
		$gov[1] = $cidade;
		for($b = 0; $b < count($asc); ++$b)
			check($gov[0].$gov[1].$gov[2]);
		for($c = 0; $c < count($sub); ++$c){
			check($gov[0].$sub[$c].$gov[2]);
			check($gov[0].$sub[$c].".".$gov[1].$gov[2]);
		}
	}
}*/

function check($gov){
	
	if($gov === NULL) return false;
	
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
	}else return false;
	
}