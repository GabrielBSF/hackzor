<?php

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
     
/*$sub[0] = "pc";
$sub[1] = "pm";
$sub[2] = "portal";
$sub[3] = "gcm";
$sub[4] = "gcmc";
$sub[5] = "policiacivil";
$sub[6] = "policiamilitar";
$sub[7] = "gcm";
$sub[8] = "camara";
$sub[9] = "prefeitura";
$sub[10] = "pc.";
$sub[11] = "pm.";
$sub[12] = "portal.";
$sub[13] = "gcm.";
$sub[14] = "gcmc.";
$sub[15] = "policiacivil.";
$sub[16] = "policiamilitar.";
$sub[17] = "gcm.";
$sub[18] = "camara.";
$sub[19] = "prefeitura.";*/
$sub = ["leideacesso.", "essic.", "lda.", "leideacesso", "essic", "lda"];

$gov[0] = "http://www.";
$gov[2] = ".gov.br/";
$gov[3] = ".leg.br/";

for($a = 0; $a < $estados; ++$a){
	$estado = strtolower($brasil["estados"][$a]["sigla"]);
	$cidades = count($brasil["estados"][$a]["cidades"]);
	if($estado === "mg"){
		for($b = 0; $b < $cidades; ++$b){
			$cidade = strtolower($brasil["estados"][$a]["cidades"][$b]);
			$cidade = strtr($cidade, $acentos);
			$gov[1] = $cidade;
		
			system("php curl.php ".$gov[0].$gov[1].".cam.".$estado.$gov[2]);
			system("php curl.php ".$gov[0].$sub[1].$gov[1].".cam.".$estado.$gov[2]);
			//system("php curl.php ".$gov[0].$gov[1].".cam.".$estado.$gov[3]);
			//system("php curl.php ".$gov[0].$gov[1].".".$estado.$gov[3]);
		
			/*for($c = 0; $c < count($sub); ++$c){
				system("php curl.php ".$gov[0].$sub[$c].$gov[1].".".$estado.$gov[2]);
				system("php curl.php ".$gov[0].$sub[$c].$gov[1].".cam.".$estado.$gov[2]);
			}*/
		}
	}
}
