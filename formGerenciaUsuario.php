<?php
	require_once('scripts/session.php');
	require_once('scripts/bd.php');
	//Acesso permitido somente a usuários de nível adminGeral ou adminDeus
	// session_validaLoginRedirect('adminGeral','adminDeus');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>GERENCIAR USUÁRIOS</title>
	</head>
	<body>
		<header>
			<?php
				session_printWelcomeMessage();
			?>
		</header>
		
		<form method = "POST" action = "gerenciaUsuario.php" enctype = "multipart/form-data">
			<fieldset>
				<label for = "busca">Buscar</label>
				<input type = "text" name = "busca"/>

				<br><br>
				<form action="gerenciaUsuario.php">
					Incluir usuário inativos?<br>
					<input type="radio" name="ativo" value=0>Sim<br>
					<input type="radio" name="ativo" value=1 checked>Não<br>
				</form>

				<br><br>

				<button type = "submit" name = "enviar">Buscar</button>
			</fieldset>

		</form>
	</body>
</html>