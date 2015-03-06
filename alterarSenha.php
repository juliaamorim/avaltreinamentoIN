<?php include("functions.php") ?>

<?php
	function alterar_Senha($conexao, $strNome, $strSenhaAtual, $strConfNovaSenha){

		mysqli_set_charset($conexao,'utf-8');
		$query = "UPDATE usuarios SET senha = '$strConfNovaSenha' WHERE  nome = '$strNome' AND senha = '$strSenhaAtual'";
		$conexao->query($query);
		
		echo "Atualização bem sucedida!!";

		header('Location:home.php');
		
		$conexao->close();
	}
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>Alterar Senha</title>
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
				session_start();
				
				if (isset($_POST['salvar'])) {
					$strNome = $_SESSION['nome'];
					$strSenhaAtual = $_POST['senhaAtual'];
					$strNovaSenha = $_POST['novaSenha'];
					$strConfNovaSenha = $_POST['confNovaSenha'];
					
					if($strSenhaAtual == '' || $strNovaSenha == '' || $strConfNovaSenha == ''){
						echo 'Existe(m) campo(s) obrigatório(s) em branco, <a href="index.html">clique aqui para tentar novamente</a>';
					} else {
						if($strNovaSenha == $strConfNovaSenha){
							$conexao = bd_conecta();
							alterar_Senha($conexao, $strNome, $strSenhaAtual, $strConfNovaSenha);
						}
					}
				}
			?>
		</form><br><br>
		
		<button><a href="index.html">Voltar para página de login</a></button>
	
	</body>
</html>
			
