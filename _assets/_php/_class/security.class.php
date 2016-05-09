<?php
/**
 * Created by Fayzor1999.
 * User: Hackzor Kruger
 * Date: 26/03/2016
 * Time: 15:10
 */
 

date_default_timezone_set("America/Sao_Paulo");

class Security{

    public function email($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL) !== FALSE){
            $domain = explode("@", $email);
            if(checkdnsrr($domain[1], "MX")){
                if(preg_match("/(^[a-zA-Z0-9_.+-]+)@([a-zA-Z_-]+).([a-zA-Z]{2,4}$)/i", $email)) return TRUE;
                else return FALSE;
            }else return FALSE;
        }else return FALSE;
    }

    public function nick($nick){
        if(preg_match("/(^[a-zA-Z0-9]{3,16}$)/i", $nick)) return TRUE;
        else return FALSE;
    }
    
    public function puzzle($captcha, $chave){
    	if($captcha == $chave) return TRUE;
    	else return FALSE;
    }
    
    public function senha($senha){
    	if(strlen($senha) >= 4 AND strlen($senha) <= 18){
    		return TRUE;
    	}else return FALSE;
    }
    
    public function existe($email, $nick){
    	global $SQL;
    	$stmt = $SQL->prepare("SELECT id FROM " . USUARIOS . " WHERE email = ? OR nick = ? ");
    	$stmt->bind_param("ss", $email, $nick);
    	$stmt->execute();
    	$stmt->bind_result($result);
    	$stmt->fetch();
    	$stmt->close();
    	if($result === NULL) return TRUE;
    	else return FALSE;
    }
    
    public function sessao($email){
    	global $SQL;
    	$stmt = $SQL->prepare("SELECT id, nick, profile, level, date, coins, jurandacoins, team_id FROM " . USUARIOS . " WHERE email = ?");
    	$stmt->bind_param("s", $email);
    	$stmt->execute();
    	$stmt->bind_result($result["id"], $result["nick"], $result["profile"], $result["level"], $result["date"], $result["coins"], $result["jurandacoins"], $result["team_id"]);
    	$stmt->fetch();
    	$stmt->close();
    	return $result;
    }

    public static function captcha($a){
		
        $gem = "mnbvcxzlkjhgfdsapoiuytrewq5432167890";
        $chave = "";

        for ($i = 0; $i < $a; $i++)
            $chave .= $gem{rand(0, strlen($gem) - 1)};

        $px = 9 * strlen($chave);
        $img = imagecreate($px, 18);
        $bg = ImageColorAllocate($img, 0, 0, 0);
        $text = ImageColorAllocate($img, 0, 200, 0);

        imagestring($img, 5, 0, 0, $chave, $text);
        imagejpeg($img,"_assets/_imgs/captcha.jpg");
		
        return $chave;
    }

}

    function registro($email, $senha, $nick, $captcha, $chave){
		if(Security::email($email)){
			if(Security::nick($nick)){
				if(Security::puzzle($captcha, $chave)){
					if(Security::existe($email, $nick)){
						if(Security::senha($senha)){
							
							//Registro
							global $SQL;
							$img = mysqli_real_escape_string($SQL, base64_encode(file_get_contents("_assets/_imgs/default.jpg")));
							$data = date("Y-m-d H:i:s"); // Year - Mounth - Day : Hour - Minutes - Seconds
							$senha = hash("sha512", $senha);
							$email = mysqli_real_escape_string($SQL, $email);
							$nick = mysqli_real_escape_string($SQL, $nick);
							$conf = md5(time().$senha.$email.$nick.$captcha.$chave);
							$stmt = $SQL->prepare("INSERT INTO ".USUARIOS." (id, profile, nick, email, pass, date, level, confirmacao, ativo, coins, jurandacoins, team_id)"
	                   .    " VALUES ('', ?, ?, ?, ?, ?, 1, ?, 0, 100, 0, '')");
	                   		$stmt->bind_param("ssssss", $img, $nick, $email, $senha, $data, $conf);
							$stmt->execute();
							$stmt->close();
							
							//Email, enviar código de confirmação
							$titulo = "Confirmar conta - Hackzor";
							$menssagem = "
								Confirmar conta (click no link):\n
								http://www.protowave.org/._fz666/?confirmar=$conf\n\n
								Tenha um ótimo game!\n
								ATT: Rozyaf1999.
							";
							$headers = "MIME-Version: 1.1\n";
							$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
							$headers .= "From: hackzor@protowave.org\n";
							$headers .= "Return-Path: hackzor@protowave.org\n";
							$headers .= "Reply-To: $email\n";
				 			
							$mail = mail($email, $titulo, $menssagem, $headers, "-fhackzor@protowave.org");
							return array(TRUE, "<p><strong>Registrado com sucesso</strong>, enviamos um código para ativação da sua conta no email!</p>");
						}else return "<p><strong>Senha muito fraca</strong>, digite no minímo 3 caracteres, máximo 18 caracteres!</p>";
					}else return "<p><strong>Conta já existente</strong>, tente outro email ou nick!</p>";
				}else return "<p><strong>Captcha inválido</strong>, digite o captcha corretamente!</p>";
			}else return "<p><strong>Nick inválido</strong>, digite no mínimo 3 caracteres, máximo 16 caracteres!</p><p>Não digite caracteres especiais, digite apenas número e letras!</p>";
		}else return "<p><strong>Email inválido</strong>, digite um email válido!</p>";
    }


    function logar($email, $senha, $captcha, $chave){
        if(Security::puzzle($captcha, $chave)){
            if(Security::email($email)){
                global $SQL;
                $senha = hash("sha512", mysqli_real_escape_string($SQL, $senha));
                $email = mysqli_real_escape_string($SQL, $email);
                $stmt = $SQL->prepare("SELECT pass, ativo FROM " . USUARIOS . " WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($result, $ativo);
                $stmt->fetch();
                $stmt->close();
                if($result === $senha){
                	if($ativo === 1) return TRUE;
                	else return "<p><strong>Login não efetuado</strong>, ative sua conta para jogar!</p>";
                }else return "<p><strong>Login não efetuado</strong>, tente efetuar o login novamente!</p>";
            }else return "<p><strong>Email inválido</strong>, digite o email corretamente!</p>";
        }else return "<p><strong>Captcha inválido</strong>, digite o captcha corretamente!</p>";
    }


	function recovery($email, $captcha, $chave){
	 	if(Security::puzzle($captcha, $chave)){
		 	if(Security::email($email)){
		 		global $SQL;
		 		$email = mysqli_real_escape_string($SQL, $email);
		 		$stmt = $SQL->prepare("SELECT confirmacao FROM " . USUARIOS . " WHERE email = ?");
		 		$stmt->bind_param("s", $email);
		 		$stmt->execute();
		 		$stmt->bind_result($conf);
		 		$stmt->fetch();
		 		$stmt->close();
		 		if($conf === NULL) return "<p><strong> Email inválido</strong>, digite o email corretamente!</p>";
		 		else{
		 			$titulo = "Recuperar conta - Hackzor";
					$menssagem = "
						Recupere sua conta (click no link):\n
						http://www.protowave.org/._fz666/?code=$conf\n\n
						Tenha um ótimo game!\n
						ATT: Rozyaf1999.
					";
					
					$headers = "MIME-Version: 1.1\n";
					$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
					$headers .= "From: hackzor@protowave.org\n";
					$headers .= "Return-Path: hackzor@protowave.org\n";
					$headers .= "Reply-To: $email\n";
		 			
					$mail = mail($email, $titulo, $menssagem, $headers, "-fhackzor@protowave.org");
					
		 			if($mail) return TRUE;
		 			else return "<p><strong>Operação falhou</strong>, realize uma nova operação!</p>";
		 		}
		 	}else return "<p><strong>Email inválido</strong>, digite o email corretamente!</p>";
	 	}else return "<p><strong>Captcha inválido</strong>, digite o captcha corretamente!</p>";
	 }

	function conta($code){//32 caracteres
		if(preg_match("/(^[a-zA-Z0-9]{32}$)/i", $code)){
			    global $SQL;
			    $code = mysqli_real_escape_string($SQL, $code);
                $stmt = $SQL->prepare("SELECT id, ativo FROM " . USUARIOS . " WHERE confirmacao = ?");
                $stmt->bind_param("s", $code);
                $stmt->execute();
                $stmt->bind_result($id, $ativo);
                $stmt->fetch();
                $stmt->close();
                if($ativo === 1 OR $id === NULL) return FALSE;
                else{
	                $stmt = $SQL->prepare("UPDATE " . USUARIOS . " SET ativo = 1 WHERE confirmacao = ?");
	                $stmt->bind_param("s", $code);
	                $result = $stmt->execute();
	                $stmt->close();
	                if($result === TRUE) return TRUE;
	                else return FALSE;
                }
		}else return FALSE;
	}

	function foto($imagem, $id){
		global $SQL;
		$tipo = explode("/", $imagem["type"][0]);
		$tamanho = round($imagem["size"][0] / 1024);
		
		if($tipo[0] === "image" AND ($tipo[1] === "png" OR $tipo[1] === "jpeg" OR $tipo[1] === "jpg")){
			if($tamanho < 300){
				$foto = mysqli_real_escape_string($SQL, base64_encode(file_get_contents($imagem["tmp_name"][0])));
				$stmt = $SQL->prepare("UPDATE " . USUARIOS . " SET profile = ? WHERE id = ?");
				$stmt->bind_param("ss", $foto, $id);
				$result = $stmt->execute();
				$stmt->close();
				if($result === TRUE) return array("mizeravi", $foto);
				else return "<p><strong>Erro na imagem</strong>, envie uma nova imagem!</p>";
			}else return "<p><strong>Imagem muito grande</strong>, envie uma imagem com menos de 300 KBytes!</p>";
		}else return "<p><strong>Imagem inválida</strong>, envie uma imagem válida!</p>";
	}