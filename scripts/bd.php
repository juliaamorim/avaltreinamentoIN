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

	//Caso de Uso: Inserir Usuário
	//TODO: Armazenar senha em HASH e valida senha usando HASH
	function bd_insereUsuario($objUsuario) {
		$objMysqli = bd_conecta();
		
		//Cria comando SQL
		$strSQL = 'INSERT INTO usuarios(nome,email,senha,nivel,id_empresa,ativo)'.'VALUES (?,?,?,?,?,?);';
		$objStmt = $objMysqli->prepare($strSQL);

		//Informa mensagem de erro na criação do comando SQL
		if(!$objStmt) {
			throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
		}

		//Preenche parâmetros SQL de forma segura
		$objStmt->bind_param('ssssii',
			$objUsuario->strNome,
			$objUsuario->strEmail,
			$objUsuario->strSenha,
			$objUsuario->strNivel,
			$objUsuario->intIdEmpresa,
			$objUsuario->intAtivo);		
		$ok = $objStmt->execute();
		
		//Tratamento do resultado da operação
		if(!$ok) {			
			throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
		}
		
		//Finaliza conexão ao BD
		$objStmt->close();
		$objMysqli->close();
		
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

	//TODO: Armazenar senha em HASH e valida senha usando HASH
	function bd_buscaUsuario($strEmail, $strSenha) {
		$objUsuario = null;
		$objMysqli = bd_conecta();
		
		//Cria comando SQL
		$strSQL = 'SELECT nome, email, nivel, id_empresa, ativo FROM usuarios WHERE email = ? AND senha = ?;';
             
        if ($objStmt = $objMysqli->prepare($strSQL)) {
        	//Preenche parâmetros SQL de forma segura
			$objStmt->bind_param('ss',$strEmail,$strSenha);

			//Executa query SQL
			if ($objStmt->execute()) {
				$objUsuario = new Usuario();

				//Configura em que variáveis serão guardados os retornos da query
				$objStmt->bind_result(
					$objUsuario->strNome,
					$objUsuario->strEmail,
					$objUsuario->strNivel,
					$objUsuario->intIdEmpresa,
					$objUsuario->intAtivo);

				//Se não houve retorno (não achou usuario), então $objUsuario = null
				if( !$objStmt->fetch() ) {
					$objUsuario = null;
				}
			}

			$objStmt->close();
        }

        //Se ocorreu algum erro, mostra mensagem de erro.
        if($objMysqli->errno) {
        	throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
        }

		//Finaliza conexão ao BD		
		$objMysqli->close();

		//Retorna objeto $objUsuario
		return $objUsuario;
	}

	function bd_printOptionsEmpresas() {
		$objMysqli = bd_conecta();
		
		//Cria comando SQL
		$strSQL = 'SELECT id, nome FROM empresas;';
             
        if ($objStmt = $objMysqli->prepare($strSQL)) {
        	
			//Executa query SQL
			if ($objStmt->execute()) {
				$objEmpresa = new Empresa();

				//Configura em que variáveis serão guardados os retornos da query
				$objStmt->bind_result(
					$objEmpresa->intId,
					$objEmpresa->strNome);
				
				//Para cada empresa no banco de dados, imprime uma opção para ela
				while( $objStmt->fetch() ) {
					echo '<option value="'.$objEmpresa->intId.'">'.$objEmpresa->strNome.'</option>';
				}
			}

			$objStmt->close();
        }

        //Se ocorreu algum erro, mostra mensagem de erro.
        if($objMysqli->errno) {
        	throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
        }

		//Finaliza conexão ao BD		
		$objMysqli->close();		
	}

	class Usuario {
		public $strNome;
		public $strEmail;
		public $strSenha;
		public $strNivel;
		public $intIdEmpresa;
		public $intAtivo;
	}

	class Empresa {
		public $intId;
		public $strNome;
	}

?>