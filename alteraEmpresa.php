<!DOCTYPE html>
<?php
	require_once('scripts/session.php');
	require_once('scripts/bd.php');
	//Acesso permitido somente a usuários de nível adminDeus
	session_validaLoginRedirect('adminDeus');
?>

<html>
<head>
	<meta charset = "utf-8"/>
	<title>Alterar Empresa</title>
</head>

<body>
	<?php
		//Obtendo os parâmetros atuais da empresa a ser alterada.
		$intId_empresa = $_GET['id_empresa'];
		$mysqli = bd_inicia();
		$strNome = 'SELECT nome FROM empresas WHERE id = $intId_empresa';
		$intAtiva = 'SELECT ativa FROM empresas WHERE id = $intId_empresa';
		global $inId_empresa, $strNome, $intAtiva;
	?>

	<center>ALTERAR EMPRESA</center>

	<form method = "POST" action = "gerenciarEmpresa.php" enctype="multipart/form-data">
		<p>Clique no campo que deseja alterar.</p>
		<fieldset>
			<label for = "nome">Nome da Empresa</label>
			<input type = "text" name = "nome" value = ""/>

			<label for = "status">Status</label>
			<input type = "text" nome = "status" value = ""/>

			<button type = "submit" name = "confirmar">Confirmar</button>
		</fieldset>
	</form>
</body>
</html>

<?php
	$strNovoNome = $_POST['nome'];
	$strNovoStatus = $_POST['status'];

	if($strNovoNome == '' || $strNovoStatus == ''){
		echo 'Todos os campos são obrigatórios. Clique <a href = "alteraEmpresa.php">aqui</a> para retornar à página anterior.'
	}else{
		$sql = 'UPDATE empresas SET (id, nome, ativa) VALUES (?, ?, ?)';
		$stmt = $mysqli->prepare($sql);

		$stmt->bind_param('isi', $inId_empresa, $strNome, $intAtiva);
		$stmt->execute();

		$stmt->close();
		$mysqli->close();
	}
?>