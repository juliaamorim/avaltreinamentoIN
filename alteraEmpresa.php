<?php include_once("layoutUp.php"); ?>
<?php
	require_once('scripts/functions.php');
	//Acesso permitido somente a usuários de nível adminDeus
	session_validaLoginRedirect('adminDeus');
	imprimeMenssagem();
	$mysqli = bd_conecta();

	if(isset($_GET['id'])){	
		$id_empresa = $_POST['id'];
	}else{
		setaMensagem('Id da empresa não especificado.', 'erro');
		$mysqli->close(); 
	 	header('Location: gerenciarEmpresa.php');
	}

	if(isset($_POST['nome']) && isset($POST['status'])){
		$strNome = $_POST['nome'];
		$strStatus = $_POST['status'];

		if($strNome == '' || $strStatus == ''){
	 		setaMensagem('Todos os campos são obrigatórios.', 'erro'); 
	 		$mysqli->close();
	 		header('Location: alteraEmpresa.php');
		}else{
			if($strStatus == "Ativada"){
				$intAtiva = 1;
			}else{
				$intAtiva = 0;
			}

			//NÃO TESTADO!!!
			$update = "UPDATE empresas SET nome = ?, status = ? WHERE id = $id_empresa;";
			
			if($stmt = $mysqli->prepare($update)){
				$stmt->bind_param('si', $strNome, $intAtiva);
				$stmt->execute();
				$stmt->close();

				setaMensagem('Empresa alterada com sucesso!', 'sucesso');		
			}else{
				setaMensagem('A empresa não pode ser alterada!', 'erro');
			}

			$mysqli->close();
			header('Location: gerenciarEmpresa.php');
		}
	}else{
		//Obtendo os parâmetros atuais da empresa a ser alterada.
		$strNome = "SELECT nome FROM empresas WHERE id = ?;";
		$intAtiva = "SELECT status FROM empresas WHERE id = ?;";

		if($stmt = $mysqli->prepare($strNome) && $stmt2 = $mysqli->prepare($intAtiva)){
			//Defino que o campo com a interrogação (não definido) na query deve ter o valor da variável do parâmetro.
			$stmt->bind_param('i', $id_empresa);
			$stmt2->bind_param('i', $id_empresa);
			$stmt->execute();
			$stmt2->execute();

			//Busco o resultado e salvo ele na variável especificada pelo parâmetro (ela não precisa estar previamente criada).
			$stmt->bind_result($strNome);
			$stmt2->bind_result($intAtiva);

			//Equivalente ao execute(), só que para result().
			$stmt->fetch();
			$stmt2->fetch();

			$stmt->close();
			$stmt2->close();
			$mysqli->close();
		}		
	}
?>

<?php /*<html>
<head>
	<meta charset = "utf-8"/>
	<title>Alterar Empresa</title>
</head>
<body> */
?>	

	<form id = "formulario" method = "POST" action = "alteraEmpresa.php" enctype="multipart/form-data">
		<p>Clique no campo que deseja alterar.</p>
		<fieldset>
			<label for = "nome">Nome da Empresa</label>
			<input form = "formulario" type = "text" name = "nome" value = "<?php print($strNome); ?>" />

			<br><br>
			
			<label for = "status">Status da Empresa</label>
			<select form = "formulario" name = "status">

			<?php if ($intAtiva == 1) {?>

				<option value = "Ativada" selected>Ativada</option>
				<option value = "Desativada">Desativada</option>
			
			<?php }else{ ?>

				<option value = "Ativada">Ativada</option>
				<option value = "Desativada" selected>Desativada</option>

			<?php } ?>

			</select>

			<br><br>

			<button type = "submit" name = "confirmar">Confirmar</button>
		</fieldset>
	</form>

<?php /*
</body>
</html>
*/?>

<?php include_once("layoutDown.php"); ?>