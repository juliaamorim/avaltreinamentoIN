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
				$objUsuario = new Usuario();
				$objUsuario->strNome = (isset($_POST['nome']) ? $_POST['nome'] : null);
				$objUsuario->strEmail = (isset($_POST['email']) ? $_POST['email'] : null);
				$objUsuario->strSenha = (isset($_POST['senha']) ? $_POST['senha'] : null);
				$objUsuario->strNivel = (isset($_POST['nivel']) ? $_POST['nivel'] : null);
				$objUsuario->intIdEmpresa = (isset($_POST['id_empresa']) ? $_POST['id_empresa'] : null);
				$objUsuario->intAtivo = 1;

				//Todos os campos são obrigatórios
				if (!$objUsuario->nome || !$objUsuario->email || !$objUsuario->senha || !$objUsuario->nivel || !$objUsuario->id_empresa) {
					echo 'Existe(m) campos(s) obrigatórios(s) em branco, <a href="window.history.go(-1)">clique aqui para tentar novamente</a>.';
				} 
				else {
					try {
						bd_insereUsuario($objUsuario);
						echo 'Usuário inserido com sucesso';
					}
					catch (Exception $objE) {
						echo 'Erro: ' . $objE->getMessage();
					}
				}

				echo '<br/>';
				echo '<br/>';
				echo '<a href="index.php">Voltar</a>';

			?>		
		</nav>
	</body>
</html>