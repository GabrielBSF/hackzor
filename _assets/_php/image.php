<?php
session_start();
//header('Content-type: image/jpeg');

if(isset($_GET["rankp"], $_GET["id"])){
	$a = $_GET["id"];
	echo base64_decode($_SESSION["ranking_personagem"]["profile"][$a]);
}elseif(isset($_GET["rankt"], $_GET["id"])){
	$a = $_GET["id"];
	echo base64_decode($_SESSION["ranking_team"]["profile"][$a]);
}elseif(isset($_GET["perfil"])){
	echo base64_decode($_SESSION["game"]["profile"]);
}else{
	echo "FUCK YOU!";
}