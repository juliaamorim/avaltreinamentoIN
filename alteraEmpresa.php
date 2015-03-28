<!DOCTYPE html>

<?php
	require_once('scripts/functions.php');
	//Acesso permitido somente a usuários de nível adminDeus
	//session_validaLoginRedirect('adminDeus');
	imprimeMenssagem();
	$mysqli = bd_conecta();

	/*if(null != $_GET(['id_empresa'])){
		$id_empresa = $_GET['id_empresa'];
	}else{
		setaMenssagem('Id da empresa não especificado. Clique  <a href = "gerenciarEmpresa.php">aqui</a>  para retornar à página anterior.', 'erro'); 
	 	header('Location: gerenciarEmpresa.php');
	}*/

	if(isset($_POST['nome']) && isset($POST['status'])){
		$strNovoNome = $_POST['nome'];
		$strNovoStatus = $_POST['status'];
		$id_empresa = 1;
		if($strNovoNome == '' || $strNovoStatus == ''){
	 		setaMenssagem('Todos os campos são obrigatórios. Clique  <a href = "alteraEmpresa.php">aqui</a>  para retornar à página anterior.', 'erro'); 
	 		$mysqli->close();
	 		header('Location: gerenciarEmpresa.php');
		}else{
			
			$sql = "UPDATE empresas SET nome = $strNovoNome, status = $strNovoStatus WHERE id = $id_empresa";
			
			if($mysqli->query($sql) == true){
				setaMenssagem('Empresa alterada com sucesso!', 'sucesso');
			}else{
				setaMenssagem('A empresa não pode ser alterada!', 'erro');
			}

			$mysqli->close();
			header('Location: gerenciarEmpresa.php');
		}
	}else{
		$id_empresa = 1;
		//Obtendo os parâmetros atuais da empresa a ser alterada.
		$strNome = "SELECT nome FROM empresas WHERE id = $id_empresa;";
		echo $strNome;
		$mysqli->close();
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
	<form method = "POST" action = "alteraEmpresa.php?id_empresa=id_empresa" enctype="multipart/form-data">
		<p>Clique no campo que deseja alterar.</p>
		<fieldset>
			<label for = "nome">Nome da Empresa</label>
			<input type = "text" name = "nome" value = "<?php print($strNome); ?>" />

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