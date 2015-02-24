<?php
	require_once('scripts/session.php');
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
		<p>Você não possui permissão para acessar esta página.</p>
		<br/>
		<a href="index.php">Voltar</a>
	</body>
</html>