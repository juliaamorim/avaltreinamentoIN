<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');
	//Acesso permitido somente a usuários de nível adminDeus
	//session_validaLoginRedirect('adminDeus');
	imprimeMenssagem();
	
	if(isset($_POST['nome'])){
		$strNome = $_POST['nome'];
		$strStatus = $_POST['status'];

		if($strNome == ''){
			setaMensagem('Por favor, insira um nome para a empresa.', 'erro');
			header('Location: alteraEmpresa.php');
		}else{
			$mysqli = bd_conecta();
			$nome = $strNome;
			
			if($strStatus == "Ativada"){
				$intAtiva = 1;
			}else{
				$intAtiva = 0;
			}

			//Cria e executa comando SQL
			if($stmt = $mysqli->prepare('INSERT INTO empresas (nome, ativa) VALUES (?, ?);')){
				$stmt->bind_param("si", $strNome, $intAtiva);
				$stmt->execute();
				$stmt->close();
				$mysqli->close();

				setaMensagem('A empresa foi inserida com sucesso!', 'sucesso');
				
			}else{
				setaMensagem('A empresa não pôde ser inserida.', 'erro');
			}

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
		<form id = "formulario" method = "POST" action = "insereEmpresa.php" enctype = "multipart/form-data">
			<fieldset>
				<label for = "nome">Nome da Empresa</label>
				<input type = "text" name = "nome"/>

				<br><br>

				
				<label for = "status">Status da Empresa</label>
				<select form = "formulario" name = "status">
					<option value = "Ativada">Ativada</option>
					<option value = "Desativada">Desativada</option>
				</select>

				<br><br>

				<button type = "submit" name = "confirmar">Confirmar</button>
			</fieldset>
		</form>
	</body> 
</html>