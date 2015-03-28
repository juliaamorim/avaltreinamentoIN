<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');
	//Acesso permitido somente a usuários de nível adminDeus
	//session_validaLoginRedirect('adminDeus');
	imprimeMenssagem();

	if(isset($_POST['nome']) && isset($POST['status'])){
		$strNome = $_POST['nome'];
		$strStatus = $_POST['status'];

		if($strNome == ''){
			echo 'Por favor, digite o nome da empresa a ser inserida. Clique <a href = "insereEmpresa.php"> aqui </a> para retornar para a página anterior.';
		}else{
				$mysqli = bd_conecta();
				$nome = $strNome;
				
				if($strStatus == "ativada"){
					$ativa = 1;
				}else{
					$ativa = 0;
				}

				//Cria comando SQL
				$stmt = $msqli->prepare('INSERT INTO empresas (nome, ativa) VALUES (?, ?);');
				$stmt->bind_param("si", $nome, $ativa);

				$stmt->execute();

				$stmt->close();
				$mysqli->close();
				setaMenssagem('A empresa foi inserida com sucesso!', 'sucesso');
				header('Location: gerenciarEmpresa.php');
		}
	}
?>

<html>
	<head>
		<meta charset = "utf-8"/>
		<title>Inserir Empresa</title>
		<link 
		href="css/style.css" 
		title="style" 
		type="text/css" 
		rel="stylesheet"
		media="all"/>
	</head>

	<body>
		<center>INSERIR EMPRESA</center>
		<br>
		<form method = "POST" action = "gerenciarEmpresa.php" enctype = "multipart/form-data">
			<fieldset>
				<label for = "nome">Nome da Empresa</label>
				<input type = "text" name = "nome"/>

				<br><br>

				
				<label for = "status">Status da Empresa</label>
				<select name = "status">
					<option value = "Ativada">Ativada</option>
					<option value = "Desativada">Desativada</option>
				</select>

				<br><br>

				<button type = "submit" name = "confirmar">Confirmar</button>
			</fieldset>
		</form>
	</body> 
</html>