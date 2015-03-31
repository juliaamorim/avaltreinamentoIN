<?php require_once('layoutUp.php');?>
	
<?php
	require_once('scripts/functions.php');
	/*ESTA FUNÇÃO GERA UMA SENHA ALEATÓRIA*/
	function gerarNovaSenha($intTamanho = 8, $blnMaiusculas = true, $blnNumeros = true, $blnSimbolos = false){
		// Caracteres de cada tipo
		$lmin = 'abcdefghijklmnopqrstuvwxyz';		
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';

		//Variaveis internas
		$retorno = '';
		$caracteres = '';

		//Agrupamos todos os caracteres que poderão ser utilizados
		$caracteres .=$lmin;
		if($blnMaiusculas) $caracteres .= $lmai;
		if($blnNumeros) $caracteres .= $num;
		if($blnSimbolos) $caracteres .= $simb;

		//Calculamos o total de caracteres possíveis
		$len = strlen($caracteres);

		for($n = 1; $n <= $intTamanho; $n++){
			//Criamos um número aleatório de 1 até $len para pegar um dos caracteres
			$rand = mt_rand(1,$len);
			// Concatenamos um dos caracteres na variável $retorno
			$retorno .= $caracteres[$rand-1];
		}
		return $retorno;
	}



	/*ESTA FUNÇÃO RECEBE O E-MAIL E A SENHA GERADA E ENVIA PARA O EMAIL DO USUÁRIO*/
	function enviarEmail($strEmail, $strSenhaGerada){
		require 'phpmailer/class.phpmailer.php';
		require 'phpmailer/class.smtp.php';
		
		$mail = new PHPMailer();
		$mail->setLanguage('pt');

		/*ESTE TRECHO CONFIGURA O SERVIDOR*/
		$host = "ssl://smtp.gmail.com:465";
		$userName = ''; // email do remetente
		$password = ''; //senha do email remetente 
		$port = 587;
		$secure = 'tls';

		/*TRECHO REFERENTE AO REMETENTE*/
		$strFrom = $userName; // ENDEREÇO DE E-MAIL DO REMETENTE
		$strFromName = 'INJUNIOR'; // NOME DO REMETENTE

		/*INICIA A CONEXÃO SMTP*/
		$mail->isSMTP();
		$mail->Host = $host;
		$mail->SMTPAuth = true;
		$mail->Username = $userName;
		$mail->Password = $password;
		$mail->Port = $port;
		$mail->secure = $secure;

		$mail->From = $strFrom;
		$mail->FromName = $strFromName;
		$mail->addReplyTo($strFrom, $strFromName); // ENDEREÇO DE E-MAIL QUE RECEBERÁ UM E-MAIL DE RESPOSTA ENVIADO  PELO USUÁRIO

		$mail->AddAddress($strEmail); // ENDEREÇO NO QUAL A SENHA GERADA SERÁ ENVIADA

		$mail->isHTML(true);
		$mail->CharSet = 'utf-8';

		$mail->Subject = 'Enviando E-mails com PHPMailer'; // ASSUNTO DO E-MAIL
		$mail->Body = '<strong>Sua senha foi alterada para:</strong>' ."$strSenhaGerada" .'<br><br><strong>Por Favor troque assim que possível.</strong>'; // CORPO DO E-MAIL COM HTML
		$mail->AltBody = 'Enviando e-mail em texto plano'; // CORPO DO E-MAIL CASO NÃO TENHA SUPORTE AO HTML

		$send = $mail->Send(); // COMANDO PARA ENVIAR O E-MAIL
		
		/*TESTE PARA VERIFICAR SE O E-MAIL FOI ENVIADO*/
		if($send){
			echo 'E-mail enviado com sucesso!';
		} else {
			echo 'Error:'.$mail->ErrorInfo;
		} 
	}

	/*ESTA FUNÇÃO RECEBE O E-MAIL DO USUÁRIO E A SENHA GERADA. APÓS ISTO ELA COLOCA A SENHA 
	GERADA NO BANCO DE DADOS*/
	function atualizaSenha($strEmail, $strSenhaGerada){
		
		$conexao = bd_conecta();
		
		mysqli_set_charset($conexao,'utf-8');

		//CRIPTOGRAFA A SENHA GERADA PARA INSERI-LA NO BANCO DE DADOS
		$strSenhaGerada = sha1($strSenhaGerada);
		
		/*ESTE TRECHO DO CÓDIGO PESQUISA DENTRO BANCO DE DADOS SE O E-MAIL
		SALVO NA VARIAVEL $strEmail EXISTE DENTRO DO MESMO*/
		$query1 = "SELECT * FROM usuarios WHERE email = '$strEmail'";
		$intResult = $conexao->query($query1);
		
		/*SE O EMAIL ESTIVER NO BANCO DE DADOS O PROGRAMA ATUALIZA A SENHA E RETORNA 1
		CASO CONTRÁRIO RETORNA 0*/
		if($intResult->num_rows > 0){
			$query2 = "UPDATE usuarios SET senha = '$strSenhaGerada' WHERE  email = '$strEmail'";
			$conexao->query($query2);
			$conexao->close();
			return 1;
		} else {
			return 0;
		}
	}					
?>

<!--FORMULÁRIO DO ESQUECEU SENHA-->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Esqueceu Senha</title>
		<link 
		href="css/style.css" 
		title="style" 
		type="text/css" 
		rel="stylesheet"
		media="all"/>
	</head>
	<body>
		<form action="" method="POST">
			<label>E-mail:</label>
			<input type="text" name="email" placeholder="digite seu email"/><br><br>
			
			<input type="submit" name="enviar" value="Enviar"/><br><br>
						
			<a href="index.php">Voltar</a>
			<?php  
				if(isset($_POST['enviar'])){
					$strEmail = $_POST['email'];
					$strSenhaGerada = gerarNovaSenha(8); // Definindo uma senha de 8 caracteres
					
					/*SE $intResult FOR MAIOR QUE ZERO ENVIA O E-MAIL
					CAS CONTRÁRIO É PORQUE O EMAIL NÃO FOI ENCONTRADO NO
					BANCO DE DADOS*/
					$intResult = atualizaSenha($strEmail, $strSenhaGerada);
					if($intResult > 0)
						enviarEmail($strEmail,$strSenhaGerada);
					else {
						$strMensagem = "Endereço de e-mail não encontrado!";
						$strTipo = "erro";
						setaMensagem($strMensagem,$strTipo);
						imprimeMensagem();
					}
				}
			?>		
		</form>
	</body>
</html>
<?php require_once('layoutDown.php');?>
