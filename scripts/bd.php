<?php
	
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