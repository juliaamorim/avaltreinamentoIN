<?php
	require_once('scripts/session.php');
	
	//Se já estiver logado, então pula tudo isso e simplesmente mostra sua Home
	//Se não está logado, entra nesse if e verifica se houve tentativa de login (o usuário está vindo do formulário de login)
	//Se não está logado e não houve tentativa de login, então pula isso e mostra a Home para usuário anônimo
	if(!session_validaLogin()) {
		//Pega login e senha passados pelo formulário de login
		$email = (isset($_POST['email']) ? $_POST['email'] : null);		
		$senha = (isset($_POST['senha']) ? $_POST['senha'] : null);

		//Tentativa de login
		if ( $email && $senha) {
			require_once('scripts/bd.php');
			$usuario = bd_buscaUsuario($email, $senha);

			//Se $usuario é null, então email e/ou senha são inválidos
			if ( is_null($usuario) ) {
				session_printWelcomeMessage();
				echo '<br/><br/>';
				die('Email e/ou senha inválidos.');
			}
			else {				
				$_SESSION['nome'] = $usuario->nome;
				$_SESSION['email'] = $usuario->email;
				$_SESSION['nivel'] = $usuario->nivel;
				$_SESSION['id_empresa'] = $usuario->id_empresa;
				$_SESSION['ativo'] = $usuario->ativo;
			}
		}
		//Preencheu somente um campo do formulário de login
		else if ( $email || $senha) {
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