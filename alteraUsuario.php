<?php
	require_once('scripts/functions.php');
	
	include "usuario.php";
	
	function alterarUsuario($objUsuario) {

		//Mock para um usuario já recuperado com id=2
		$id_usuario = 2;

		$nome=$objUsuario->getNome();
		$email=$objUsuario->getEmail();
		$senha=$objUsuario->getSenha();
		$nivel=$objUsuario->getNivel();
		$ativo=$objUsuario->getAtivo();
		$empresa=$objUsuario->getEmpresa();
		

		$strSQL = "UPDATE usuarios SET nome=?, email=?, senha=?, nivel=?, id_empresa=Coalesce($empresa), ativo=? WHERE id=?;";
		
		$objMysqli = bd_conecta();
		
		$objStmt = $objMysqli->prepare($strSQL);

		if(!$objStmt) {
			throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
		}

		$objStmt->bind_param('ssssii',
			$nome,
			$email,
			$senha,
			$nivel,
			$ativo,
			$id_usuario);		
		
		$ok = $objStmt->execute();
		
		if(!$ok) {			
			throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
		}

		$objStmt->close();
		$objMysqli->close();

	}

	//***Chamada para visualizar o Usuário a ser editado***
	
	$objUsuario = new Usuario();
	
	$objUsuario->setNome(isset($_POST['nome']) ? $_POST['nome'] : null);
	$objUsuario->setEmail(isset($_POST['email']) ? $_POST['email'] : null);
	$objUsuario->setSenha(isset($_POST['senha']) ? $_POST['senha'] : null);
	$objUsuario->setNivel(isset($_POST['nivel']) ? $_POST['nivel'] : null);
	$objUsuario->setEmpresa(isset($_POST['id_empresa']) ? $_POST['id_empresa'] : null);
	$objUsuario->setAtivo(1);

	if (!$objUsuario->getNome() || !$objUsuario->getEmail() || !$objUsuario->getSenha() || !$objUsuario->getNivel() || !$objUsuario->getEmpresa()) {
		echo 'Existe(m) campos(s) obrigatórios(s) em branco, <a href="window.history.go(-1)">clique aqui para tentar novamente</a>.';
	} 
	else {
		try {
			alterarUsuario($objUsuario);
			echo 'Usuário alterado com sucesso';
		}
		catch (Exception $objE) {
			echo 'Erro: ' . $objE->getMessage();
		}
	}

	echo '<br/>';
	echo '<br/>';
	echo '<a href="index.php">Voltar</a>';

?>		
	
