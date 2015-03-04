<?php

	//Cria conexão ao banco de dados e retorna o objeto de link
	function bd_conecta() {
		$objMysqli = new mysqli('localhost','root','injunior','avaltreinamento');
		
		if ($objMysqli->connect_errno){
			die('Falha na conexão ao banco de dados: '.mysqli_connect_error());
		}
		
		$objMysqli->set_charset('latin1_swedish_ci');

		return $objMysqli;
	}

	

	function alterarUsuario($objUsuario) {

		$strSQL = "UPDATE usuarios SET (nome, email, senha, nivel, ativo) 
		VALUES (?, ?, ?, ?, ?);";
		
		$objStmt = $objMysqli->prepare($strSQL);

		if(!$objStmt) {
			throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
		}

		$objStmt->bind_param('ssssi',
			$objUsuario->strNome,
			$objUsuario->strEmail,
			$objUsuario->strSenha,
			$objUsuario->strNivel,
			$objUsuario->intAtivo);		
		
		$ok = $objStmt->execute();
		
		if(!$ok) {			
			throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
		}

		$objStmt->close();
		$objMysqli->close();

	}

?>