<?php
	require_once('scripts/session.php');
	require_once('scripts/bd.php');
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
				//Recupera informações a serem armazenadas
				$usuario = new Usuario();
				$usuario->nome = (isset($_POST['nome']) ? $_POST['nome'] : null);
				$usuario->email = (isset($_POST['email']) ? $_POST['email'] : null);
				$usuario->senha = (isset($_POST['senha']) ? $_POST['senha'] : null);
				$usuario->nivel = (isset($_POST['nivel']) ? $_POST['nivel'] : null);
				$usuario->id_empresa = (isset($_POST['id_empresa']) ? $_POST['id_empresa'] : null);
				$usuario->ativo = 1;

				//Todos os campos são obrigatórios
				if (!$usuario->nome || !$usuario->email || !$usuario->senha || !$usuario->nivel || !$usuario->id_empresa) {
					echo 'Existe(m) campos(s) obrigatórios(s) em branco, <a href="window.history.go(-1)">clique aqui para tentar novamente</a>.';
				} 
				else {
					try {
						bd_insereUsuario($usuario);
						echo 'Usuário inserido com sucesso';
					}
					catch (Exception $e) {
						echo 'Erro: ' . $e->getMessage();
					}
				}

				echo '<br/>';
				echo '<br/>';
				echo '<a href="index.php">Voltar</a>';

			?>		
		</nav>
	</body>
</html>