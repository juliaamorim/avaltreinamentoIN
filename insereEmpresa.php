<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');
	require_once('scripts/bd.php');
	//Acesso permitido somente a usuários de nível adminDeus
	session_validaLoginRedirect('adminDeus');
	session_printWelcomeMessage();

	if(isset($_POST['nome']) && isset($POST['status'])){
		$strNome = $_POST['nome'];
		$strStatus = $_POST['status'];

		if($strNome == '' || $strStatus == ''){
			echo 'Existem um ou mais campos em branco. Clique <a href = "insereEmpresa.php"> aqui </a> para retornar para a página anterior.';
		}else{
			if($strStatus != "ativada" && $strStatus != "desativada"){
				setaMenssagem('As opções disponíveis para o campo status são "ativada" ou "desativada". 
				Clique <a href = "insereEmpresa.php">aqui</a> para retornar para a página anterior.', 'Fracasso');
				imprimeMenssagem();
			}else{
				$mysqli = bd_conecta();

				$id_empresa = default;
				$nome = $strNome;
				
				if($strStatus == "ativada"){
					$ativa = 1;
				}else{
					$ativa = 0;
				}

				//Cria comando SQL
				$stmt = $msqli->prepare('INSERT INTO empresas (id_empresa, nome, ativa) VALUES (?, ?, ?);');
				$stmt->bind_param("isi", $id_empresa, $nome, $ativa);

				$stmt->execute();

				$stmt->close();
				$mysqli->close();
				setaMenssagem('A empresa foi inserida com sucesso!', 'Sucesso');
				imprimeMenssagem();
			}
		}
	}
?>

<html>
	<head>
		<meta charset = "utf-8"/>
		<title>Inserir Empresa</title>
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
				<input type = "text" placeholder = "ativada/desativada" name = "status"/>

				<br><br>

				<button type = "submit" name = "confirmar">Confirmar</button>
			</fieldset>
		</form>
	</body> 
</html>