<?php include_once('layoutUp.php'); ?>

<?php
	//Se já estiver logado, então não permite fazer Login
	if ( session_validaLogin() ) {
		setaMensagem('Antes de logar com outra conta voc&ecirc; precisa fazer o logout de sua conta atual.', 'info');
		imprimeMenssagem();
		// echo '<p>Antes de logar com outra conta voc&ecirc; precisa fazer o logout de sua conta atual.</p>';
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

<?php include_once('layoutDown.php'); ?>			
