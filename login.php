<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');
?>
<html lang="pt-BR">
	<head>
		<title>Login SAT</title>
	</head>
	<body>
		<header>
			<?php
				session_printWelcomeMessage();
			?>
		</header>
		<section>
			<?php
				//Se já estiver logado, então não permite fazer Login
				if ( session_validaLogin() ) {
					echo '<p>Antes de logar com outra conta você precisa fazer o logout de sua conta atual.</p>';
				}
				//Se não estiver logado, mostra o Formulário de Login a seguir
				else {
			?>					
					<form name="loginForm" method="POST" action="index.php">				
						Email: <input type="text" name="email" required></input><br/>
						Senha: <input type="password" name="senha" required></input><br/>
						<button type="submit">Logar</button>
					</form>
			<?php
				}
			?>			
		</section>
	</body>
</html>