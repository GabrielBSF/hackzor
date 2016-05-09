<?php
/**
 * Created by Fayzor1999.
 * User: Hackzor Kruger
 * Date: 26/03/2016
 * Time: 18:33
 */

session_start();

$result = "";

if(isset($_FILES["foto"])){
	$result = foto($_FILES["foto"], $_SESSION["game"]["id"]);
	if($result[0] === "mizeravi")
		$_SESSION["game"]["profile"] = $result[1];
}

if(isset($_GET["confirmar"])){
	$result = conta($_GET["confirmar"]);
    echo $result;
}

if(!isset($_SESSION["game"], $_SESSION["time"])){
	if(isset($_POST["fgtemail"], $_POST["captcha"], $_SESSION["captcha"])){//Recuperar conta
		$result = recovery($_POST["fgtemail"], $_POST["captcha"], $_SESSION["captcha"]);
	}
	elseif(isset($_POST["lgemail"], $_POST["lgsenha"], $_POST["captcha"], $_SESSION["captcha"])){//Login
	    $result = logar($_POST["lgemail"], $_POST["lgsenha"], $_POST["captcha"], $_SESSION["captcha"]);
	    if($result === TRUE){
	    	$_SESSION["time"] = time();
	    	$_SESSION["game"] = Security::sessao($_POST["lgemail"]);
	    	header("Location: index.php");
	    	exit;
	    }
	}
	elseif(isset($_POST["cademail"], $_POST["cadsenha"], $_POST["cadnick"], $_POST["captcha"], $_SESSION["captcha"])){//Cadastro
		$result = registro($_POST["cademail"], $_POST["cadsenha"], $_POST["cadnick"], $_POST["captcha"], $_SESSION["captcha"]);
	}
}elseif(isset($_SESSION["email"], $_SESSION["time"], $_POST["change"])){
	
}

$_SESSION["captcha"] = Security::captcha(rand(4, 8));

if(isset($_GET["logout"])){
	header("Location: index.php");
	session_destroy();
	exit;
}