<?php
/**
 * Created by Fayzor1999.
 * User: Hackzor Kruger
 * Date: 26/03/2016
 * Time: 23:10
 */
 session_start();
 
 if(!isset($_SESSION["game"], $_SESSION["time"]) OR isset($_GET["logout"])){
 	session_destroy();
 	unset($_SESSION, $_GET, $_POST);
 	header("Location: index.php?logout");
 	exit;
 }
 
 ?>
 
 <!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
	<link rel=icon href=ico.jpg sizes="57x57" type="image/jpeg"/>
	 <head>
	 	<meta charset="UTF-8"/>
	 	<title>Hackzor - Dunning Kruger</title>
	 	
	 	    <!-- CSS -->
			<link type="text/css" rel="stylesheet" href="_assets/_css/game.css"/>
			
		    <!-- JS -->
    		<script type="text/javascript" src="_assets/_js/_libs/jquery-2.2.2.min.js"></script>
    		<script type="text/javascript" src="_assets/_js/_libs/jquery.sliphover.min.js"></script>
    		<script type="text/javascript" src="_assets/_js/game.js.php"></script>
	 </head>
	 
	 <body>
	 	
	 	<div id="interface">
	 		
	 	    <header id="cabecalho">
	 	    	
	 	    	<nav id="menu">
            		<h1>Menu Principal</h1>
            		<ul>
                		<li><a href="index.php">Home</a></li>
                		<li><a href="#perfil">Meu Perfil</a></li>
                		<li><a href="#broadcast">Broadcast</a></li>
                		<li><a href="#ranking">Ranking</a></li>
                		<li><a href="?logout">Logout</a></li>
            		</ul>
        		</nav>
        		
    		</header>
    		
    		<section id="player">
    			<div id="personagem">
    				<table>
    					<tr>
    						<tr><td><img data-caption="<a id='caption'><?php echo $_SESSION["game"]["nick"] ?></a>" width="220px" height="250px" src="_assets/_php/image.php?perfil"/></td></tr>
    						<tr><td><a><span>Level: </span><?php echo $_SESSION["game"]["level"] ?></a></td></tr>
    						<tr><td><a><span>Team: </span><?php if($_SESSION["game"]["team"] === NULL) echo "Nenhuma";else echo $_SESSION["game"]["team"]; ?></a></td></tr>
    						<tr><td><a><span>Ranking: </span><?php echo (array_search($_SESSION["game"]["nick"], $_SESSION["ranking_personagem"]["nick"]) + 1); ?></a></td></td></tr>
    						<tr><td><a><span>Coins: </span><?php echo $_SESSION["game"]["coins"]; ?></a></td></tr>
    						<tr><td><a><span>JurandaCoins: </span><?php echo $_SESSION["game"]["jurandacoins"]; ?></a></td></tr>
    					</tr>
    				</table>
        		</div>
        		
        	</section>
        	
        	<aside id="game">

        		<nav id="jogo">
	        		<p>Bem vindo ao game</p>
	        		<p></p>
        		</nav>
        		<nav id="jogo">
	        		<p>Tetestestefdsfdsfsdfdsfdsfsdfstes</p>fdsfsdfds
        		</nav>

        	</aside>
        	
        	<footer id="rodape">
    			<p><a id="copy">Copyright &copy 2016 | Hackzor</a></p>
			</footer>
        	
        </div>
	 	
	 </body>
</html>