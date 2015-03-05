<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');

	class Usuario {
		public $strNome;
		public $strEmail;
		public $strNivel;
		public $intIdEmpresa;
		public $intAtivo;
	}

	//TODO: Armazenar senha em HASH e valida senha usando HASH
	function buscaUsuario($strEmail, $strSenha) {
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
	
	//Se já estiver logado, então pula tudo isso e simplesmente mostra sua Home
	//Se não está logado, entra nesse if e verifica se houve tentativa de login (o usuário está vindo do formulário de login)
	//Se não está logado e não houve tentativa de login, então pula isso e mostra a Home para usuário anônimo
	if(!session_validaLogin()) {
		//Pega login e senha passados pelo formulário de login
		$strEmail = (isset($_POST['email']) ? $_POST['email'] : null);		
		$strSenha = (isset($_POST['senha']) ? $_POST['senha'] : null);

		//Tentativa de login
		if ( $strEmail && $strSenha) {
			$objUsuario = buscaUsuario($strEmail, $strSenha);

			//Se $usuario é null, então email e/ou senha são inválidos
			if ( is_null($objUsuario) ) {
				session_printWelcomeMessage();
				echo '<br/><br/>';
				die('Email e/ou senha inválidos.');
			}
			else {				
				$_SESSION['nome'] = $objUsuario->strNome;
				$_SESSION['email'] = $objUsuario->strEmail;
				$_SESSION['nivel'] = $objUsuario->strNivel;
				$_SESSION['id_empresa'] = $objUsuario->intIdEmpresa;
				$_SESSION['ativo'] = $objUsuario->intAtivo;
			}
		}
		//Preencheu somente um campo do formulário de login
		else if ( $strEmail || $strSenha) {
			session_printWelcomeMessage();
			echo '<br/><br/>';
			die('Todos os campos do formulário de login são obrigatórios.');
		}
	}
	
?>
<html lang="pt-BR">
	<head>
		<title>SAT - Sistema de Avaliação de Treinamento</title>
	</head>
	<body>
		<header>
			<?php
				session_printWelcomeMessage();
			?>
		</header>
		<nav>
			<?php
				if ( session_validaLogin('adminGeral','adminDeus') ) {
					echo '<a href="formInserirUsuario.php">Inserir Usuário</a>';
				}
			?>			
		</nav>
	</body>
</html>