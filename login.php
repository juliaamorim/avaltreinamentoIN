<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');
?>
<html lang="pt-BR">
	<head>
		<title>Login SAT</title>
		<link 
		href="css/style.css" 
		title="style" 
		type="text/css" 
		rel="stylesheet"
		media="all"/>
	</head>
	<body>
		<?php include('layoutUp.php'); ?>
		<!-- <section id="main"> aberto no layoutUp-->
		
			<article id="content"> <!-- basicamente botar todo php que mostra página pro usuário -->
				<?php
					//Se já estiver logado, então não permite fazer Login
					if ( session_validaLogin() ) {
						echo '<p>Antes de logar com outra conta você precisa fazer o logout de sua conta atual.</p>';
					}
					//Se não estiver logado, mostra o Formulário de Login a seguir
					else {
				?>					
						<form name="loginForm" method="POST" action="index.php">
							<h2>Login</h2>
							Email: <input type="text" name="email" required></input><br/>
							Senha: <input type="password" name="senha" required></input><br/>
							<button type="submit">Logar</button>
						</form>
						<p> <a href="esqueceuSenha.php"> Esqueceu Senha?</a> </p>
				<?php
					}
				?>
			</article> 
		</section> <!-- fechando o <section id="main"> aberto no layoutUp-->
		
		<?php include('layoutDown.php'); ?>			
	</body>
</html>