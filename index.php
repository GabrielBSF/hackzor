<?php
/* Includes */
ini_set('display_errors', true);
include "_assets/default.inc.php";

$_SESSION["ranking_personagem"] = rankPersonagem();
$_SESSION["ranking_team"] = rankTeam();
?>
<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<link rel=icon href=ico.jpg sizes="57x57" type="image/jpeg"/>
<head>
    <meta charset="UTF-8"/>
    <title>Hackzor - Dunning Kruger</title>

    <!-- CSS -->
    <link type="text/css" rel="stylesheet" href="_assets/_css/style.css"/>

    <!-- JS -->
    <script type="text/javascript" src="_assets/_js/_libs/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="_assets/_js/_libs/jquery.sliphover.min.js"></script>
    <script type="text/javascript" src="_assets/_js/func_principal.js.php"></script>
    <script type="text/javascript" src="_assets/_js/longuinho.js.php"></script>

    <script>
        function mudar(){
            document.forms['fotinho'].submit();
        }
    </script>

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>

<div id="interface">
    <header id="cabecalho">
        <hgroup>
            <h1>Hackzor</h1>
            <h4>Dunning Kruger</h4>
        </hgroup>
        <nav id="menu">
            <h1>Menu Principal</h1>
            <ul>
                <li><a href="#index">Home</a></li>
                <li><a href="#register">Register</a></li>
                <li><a href="#ranking">Ranking</a></li>
            </ul>
        </nav>
    </header>

    <section id="corpo">
        <div id="not">
            <div id="cab">
                <a id="data">data</a>
                <a id="titulo">Titulo</a>
            </div>
            <div id="conteudo">
                <p>Conteudo</p>
            </div>
        </div>

        <div id="ranking">
            <div id="cab">
                <a id="titulo">Ranking</a>
            </div>
            <div id="conteudo"><div id="rankingP"><table>
            	<?php
					for($a = 0, $b = 0; count($_SESSION["ranking_personagem"]["nick"]) > $a; ++$a, ++$b){
						if($b === 4){echo "<tr>";}
						echo "<td>
								<p>Rank ".($a + 1)."</p>
								<p><img width=\"120px\" height=\"140px\" src=\"_assets/_php/image.php?rankp&id=$a\" data-caption=\"<a id='rank_a'>".$_SESSION["ranking_personagem"]["nick"][$a]."</a>\"/></p>
								<p>level: ".$_SESSION["ranking_personagem"]["level"][$a]."</p>
							<p>	".$_SESSION["ranking_personagem"]["date"][$a]."</p>
								</td>
						";
						if($b === 4){echo "</tr>"; $b = 0;}
					}
            	?></table></div>
            </div>
        </div>
    </section>

<aside id="lateral">
		                <?php
		                	if(is_array($result)){
		                		if($result[0] === TRUE){
			                		echo '
		                        		<fieldset id="aviso"><legend align="center">Aviso</legend>
	                						'.$result[1].'
	            						</fieldset>
		                        	';
		                		}
		                	}elseif($result !== "" AND $result !== TRUE AND $result !== FALSE){
	                        	echo '
	                        		<fieldset id="erro"><legend align="center">Erro</legend>
                						'.$result.'
            						</fieldset>
	                        	';
	                        }elseif($result === TRUE){
	                        	echo '
	                        		<fieldset id="aviso"><legend align="center">Aviso</legend>
                						<p><strong>OK</strong>, operação realizada com sucesso!</p>
            						</fieldset>
	                        	';
	                        }
                    	?>
<? if(!isset($_SESSION["game"], $_SESSION["time"])){ echo '
    <div id="login">
        <nav  id="menu-lateral">
            <form name="login" method="POST">
                <fieldset id="fazerlogin"><legend align="center">Entrar no game</legend>

                    <fieldset id="dados"><legend>Email/senha</legend>
                        <p><input placeholder="Email" min="6"  maxlength="64" name="lgemail" id="email" class="form" type="email" required/></p>
                        <p><input placeholder="Senha" min="4" maxlength="32" size="20" name="lgsenha" id="senha" class="form" type="password" required/></p>
                    </fieldset>

                    <fieldset id="captcha"><legend align="center">Captcha</legend>
                        <p><img src="_assets/_imgs/captcha.jpg"/></p>
                        <p><input placeholder="Captcha" name="captcha" class="captcha" type="text" maxlength="12" required/></p>
                    </fieldset>

                    <fieldset id="rbt"><legend>Entrar</legend>
                        <p><input class="button" type="submit" value="Login"><a class="forget" onmouseover="this.style.cursor=\'pointer\'">Esqueci minha senha</a></p>
                    </fieldset>

                </fieldset>
            </form>
        </nav>
    </div>

    <div id="forget">
        <nav  id="menu-lateral">
            <form name="forget" method="POST">
                <fieldset id="esqueci"><legend align="center">Recuperar senha</legend>

                    <fieldset id="dados"><legend>Lembrar por email</legend>
                        <p><input placeholder="Email" min="6"  maxlength="64" name="fgtemail" id="fgtemail" class="form" type="email" required/></p>
                    </fieldset>

                    <fieldset id="captcha"><legend align="center">Captcha</legend>
                        <p><img src="_assets/_imgs/captcha.jpg"/></p>
                        <p><input placeholder="Captcha" class="captcha" name="captcha" type="text" maxlength="12" required/></p>
                    </fieldset>

                    <fieldset id="rbt"><legend>Recuperar senha</legend>
                        <p><input class="button" type="submit" value="Redefinir senha"><a class="rlogin" onmouseover="this.style.cursor=\'pointer\'">Área de login</a></p>
                    </fieldset>

                </fieldset>

            </form>
        </nav>
    </div>
    
    <div id="register">
        <nav id="menu-lateral">
            <form name="cadastro" method="POST">
                <fieldset id="cadastro"><legend align="center">Cadastro</legend>

                    <fieldset id="dados"><legend>Preencher dados</legend>
                        <p><input placeholder="Email" min="6"  maxlength="64" name="cademail" id="cademail" class="form" type="email" required/></p>
                        <p><input placeholder="Senha" min="4"  maxlength="18" name="cadsenha" id="cadsenha" class="form" type="password" required/></p>
                        <p><input placeholder="Nickname" min="3"  maxlength="12" name="cadnick" id="cadnick" class="form" required/></p>
                    </fieldset>

                    <fieldset id="captcha"><legend align="center">Captcha</legend>
                        <p><img src="_assets/_imgs/captcha.jpg"/></p>
                        <p><input placeholder="Captcha" class="captcha" name="captcha" type="text" maxlength="12" required/></p>
                    </fieldset>

                    <fieldset id="rbt"><legend>Registrar</legend>
                        <p><input class="button" type="submit" value="Registrar"><a class="clogin" onmouseover="this.style.cursor=\'pointer\'">Área de login</a></p>
                    </fieldset>

                </fieldset>

            </form>
        </nav>
    </div>';}else{
    	echo "
    	
    	<div id=\"longuinho\">
    		<nav id=\"menu-lateral\">
    			<table id=\"longed\" cellspacing=\"0\" cellpadding=\"0\">
    				<caption><a>Bem-vindo ao Hackzor</a></caption>
    				<tbody>
	    				<tr><td rowspan=\"7\">
	    				
	    				
	    				<img width=\"135px\" height=\"180px\" src=\"_assets/_php/image.php?perfil\"
	    				data-caption=\""."
<form id='fotinho' method='POST' enctype='multipart/form-data'>

<label for='imagem'><span class='btn'>Enviar imagem</span></label>

<input id='imagem' onchange='mudar();' name='foto[]' type='file' style='visibility: hidden; position: absolute;' accept='image/png, image/jpeg, image/jpg, image/gif, image/jpe' required/></form>\" \>
".'
	    				</td></tr>
	    				<tr><td width="60%" height="10%"><p>Nick: '.$_SESSION["game"]["nick"].'</p></td></tr>
	    				<tr><td><p>Level: '.$_SESSION["game"]["level"].'</p></td></tr>
	    				<tr><td><p>Classe: '.'Newbie'.'</p></td></tr>
	    				<tr><td><p>Team: '.'Anonymous Reckers'.'</p></td></tr>
	    				<tr><td><p>Ranking: '.(array_search($_SESSION["game"]["nick"], $_SESSION["ranking_personagem"]["nick"]) + 1).'</p></td></tr>
	    				<tr><td><p>Registro: '.$_SESSION["game"]["date"].'</p></td></tr>
    				</tbody>
    				<tfoot><tr><td><a class="button" href="?logout">Sair do game</a></td><td><a class="button" href="game.php">Ir para o game</a></td></tr></tfoot>
    			</table>
    		</nav>
    	</div>
    	
    	';
    }
    
    ?>

    <p>Conteúdo</p>

</aside>

<footer id="rodape">
    <p><a id="copy">Copyright &copy 2016 | Hackzor</a></p>
</footer>
</div>
</body>
</html>