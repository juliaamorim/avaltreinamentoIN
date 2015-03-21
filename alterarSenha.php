<?php 
	require_once('scripts/functions.php');
?>

<?php
	function alterar_Senha($conexao, $strEmail, $strSenhaAtual, $strConfNovaSenha){

		//CRIPTOGRAFA A SENHA PARA COMPARA-LA COM A DO BANCO DE DADOS
		$strSenhaAtual = sha1($strSenhaAtual);

		//CRIPTOGRAFA A SENHA PARA INSERI-LA NO BANCO DE DADOS
		$strConfNovaSenha = sha1($strConfNovaSenha);

		mysqli_set_charset($conexao,'utf-8');

		$query = "UPDATE usuarios SET senha = '$strConfNovaSenha' WHERE  email = '$strEmail' AND senha = '$strSenhaAtual'";
		$conexao->query($query);
		//"Atualização bem sucedida!!";

		header('Location:index.php');
		
		$conexao->close();
	}
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Alterar Senha</title>
		<link 
		href="css/style.css" 
		title="style" 
		type="text/css" 
		rel="stylesheet"
		media="all"/>
	</head>
	<body>
		<form action="" method="POST" enctype="multipart/form-data">
			
			<label><strong>Digite a senha atual</strong></label><br>
			<input type="password" name="senhaAtual"/><br>
			
			<label ><strong>Digite a nova senha</strong></label><br>
			<input type="password" name="novaSenha"/><br>
			
			<label ><strong>Confirme a nova senha</strong></label><br>
			<input type="password" name="confNovaSenha"/><br><br>
			
			<input type="submit" name="salvar" value="Salvar Alterações"><br>
			
			<?php
				
				if (isset($_POST['salvar'])) {
					
					$strEmail = $_SESSION['email'];
					$strSenhaAtual = $_POST['senhaAtual'];
					$strNovaSenha = $_POST['novaSenha'];
					$strConfNovaSenha = $_POST['confNovaSenha'];
					
					if($strSenhaAtual == '' || $strNovaSenha == '' || $strConfNovaSenha == ''){
						echo 'Existe(m) campo(s) obrigatório(s) em branco, <a href="index.html">clique aqui para tentar novamente</a>';
					} else {
						if($strNovaSenha == $strConfNovaSenha){
							$conexao = bd_conecta();
							alterar_Senha($conexao, $strEmail, $strSenhaAtual, $strConfNovaSenha);
						}
					}
				}
			?>
		</form><br><br>
		
		<button><a href="index.html">Voltar para página de login</a></button>
	
	</body>
</html>
			
