<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');
	require_once('scripts/bd.php');
	//Acesso permitido somente a usuários de nível adminDeus
	//session_validaLoginRedirect('adminDeus');
	session_printWelcomeMessage();

	if(isset($_POST['nome']) && isset($POST['status'])){
		$strNovoNome = $_POST['nome'];
		$strNovoStatus = $_POST['status'];

		if($strNovoNome == '' || $strNovoStatus == ''){
	 		setaMenssagem('Todos os campos são obrigatórios. Clique  <a href = "alteraEmpresa.php">aqui</a>  para retornar à página anterior.', 'Fracasso'); 
	 		imprimeMenssagem();
		}else{
			$sql = 'UPDATE empresas SET (id, nome, ativa) VALUES (?, ?, ?)';
			$stmt = $mysqli->prepare($sql);

			$stmt->bind_param('isi', $inIdEmpresa, $strNome, $intAtiva);
			$stmt->execute();

			$stmt->close();
			$mysqli->close();

			setaMenssagem('Empresa alterada com sucesso!', 'Sucesso'); 
	 		imprimeMenssagem();
		}
	}else{
		//Obtendo os parâmetros atuais da empresa a ser alterada.
		//$intIdEmpresa = $_GET['id_empresa'];
		$intIdEmpresa = 1;
		$mysqli = bd_conecta();

		$strNome = 'SELECT nome FROM empresas WHERE id = $intIdEmpresa;';
		$intAtiva = 'SELECT ativa FROM empresas WHERE id = $intIdEmpresa;';
	}
?>

<html>
<head>
	<meta charset = "utf-8"/>
	<title>Alterar Empresa</title>
</head>

<body>
	<?php
		
	?>

	<center>ALTERAR EMPRESA</center>

	<form method = "POST" action = "alteraEmpresa.php" enctype="multipart/form-data">
		<p>Clique no campo que deseja alterar.</p>
		<fieldset>
			<label for = "nome">Nome da Empresa</label>
			<input type = "text" name = "nome" value = "<?php echo '$strNome' ?>" />

			<label for = "status">Status</label>
			<input type = "text" nome = "status" value = "<?php echo '$intAtiva' ?>" />

			<button type = "submit" name = "confirmar">Confirmar</button>
		</fieldset>
	</form>
</body>
</html>