<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');
?>
<html lang="pt-BR">
	<head>
		<title>SAT - Sistema de Avaliação de Treinamento</title>
		<link 
		href="css/style.css" 
		title="style" 
		type="text/css" 
		rel="stylesheet"
		media="all"/>
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