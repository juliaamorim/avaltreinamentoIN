<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');
	//Acesso permitido somente a usuários de nível adminDeus
	session_validaLoginRedirect('adminDeus');
	session_printWelcomeMessage();

	if(isset($_GET['id_empresa']){
		$id_empresa = $_GET['id_empresa'];
	}else{
		setaMenssagem('Id da empresa não especificado. Clique  <a href = "gerenciarEmpresa.php">aqui</a>  para retornar à página anterior.', 'erro'); 
	 	imprimeMenssagem();
	}

	if(isset($_POST['nome']) && isset($POST['status'])){
		$strNovoNome = $_POST['nome'];
		$strNovoStatus = $_POST['status'];

		if($strNovoNome == '' || $strNovoStatus == ''){
	 		setaMenssagem('Todos os campos são obrigatórios. Clique  <a href = "alteraEmpresa.php">aqui</a>  para retornar à página anterior.', 'erro'); 
	 		imprimeMenssagem();
		}else{
			$sql = 'UPDATE empresas SET (id, nome, ativa) VALUES (?, ?, ?)';
			$stmt = $mysqli->prepare($sql);

			$stmt->bind_param('isi', $id_empresa, $strNome, $intAtiva);
			$stmt->execute();

			$stmt->close();
			$mysqli->close();

			setaMenssagem('Empresa alterada com sucesso!', 'Sucesso'); 
	 		imprimeMenssagem();
		}
	}else{
		//Obtendo os parâmetros atuais da empresa a ser alterada.
		$mysqli = bd_conecta();
		$strNome = $msqli->prepare('SELECT nome FROM empresas WHERE id = $intIdEmpresa;');
	}
?>

<html>
<head>
	<meta charset = "utf-8"/>
	<title>Alterar Empresa</title>
	<link 
		href="css/style.css" 
		title="style" 
		type="text/css" 
		rel="stylesheet"
		media="all"/>
</head>

<body>

	<center>ALTERAR EMPRESA</center>

	<form method = "POST" action = "alteraEmpresa.php?id_empresa=id_empresa" enctype="multipart/form-data">
		<p>Clique no campo que deseja alterar.</p>
		<fieldset>
			<label for = "nome">Nome da Empresa</label>
			<input type = "text" name = "nome" value = "<?php echo $strNome; ?>" />

			<label for = "status">Status da Empresa</label>
			<select name = "status">
				<option value = "Ativada">Ativada</option>
				<option value = "Desativada">Desativada</option>
			</select>

			<button type = "submit" name = "confirmar">Confirmar</button>
		</fieldset>
	</form>
</body>
</html>