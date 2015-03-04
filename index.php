<?php
	require_once('scripts/session.php');
	
	//Se já estiver logado, então pula tudo isso e simplesmente mostra sua Home
	//Se não está logado, entra nesse if e verifica se houve tentativa de login (o usuário está vindo do formulário de login)
	//Se não está logado e não houve tentativa de login, então pula isso e mostra a Home para usuário anônimo
	if(!session_validaLogin()) {
		//Pega login e senha passados pelo formulário de login
		$strEmail = (isset($_POST['email']) ? $_POST['email'] : null);		
		$strSenha = (isset($_POST['senha']) ? $_POST['senha'] : null);

		//Tentativa de login
		if ( $strEmail && $strSenha) {
			require_once('scripts/bd.php');
			$objUsuario = bd_buscaUsuario($strEmail, $strSenha);

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
<!DOCTYPE html>
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