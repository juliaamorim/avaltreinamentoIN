<?php
	require_once('scripts/session.php');
	require_once('scripts/bd.php');
	//Acesso permitido somente a usuários de nível adminGeral ou adminDeus
	session_validaLoginRedirect('adminGeral','adminDeus');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Formulário de inserção de usuário</title>
	</head>
	<body>
		<header>
			<?php
				session_printWelcomeMessage();
			?>
		</header>
		<form action="insereUsuario.php" method="POST">
			Nome: <input name='nome' type='text' required></input><br/>
			Email: <input name='email' type='text' required></input><br/>
			Senha: <input name='senha' type='password' required></input><br/>
			Nível: 
			<select name="nivel" required>
				<option value="aluno" selected>Aluno</option>
				<option value="admin">Membro de RH</option>
				<?php 
					if ( session_validaLogin('adminDeus') ) {
				?>
						<option value="adminGeral">Diretor de RH</option>
						<option value="adminDeus">Admin Deus</option>
				<?php
					}
				?>				
			</select><br/>
			<?php 
				if ( session_validaLogin('adminDeus') ) {
			?>
					Id_Empresa:
					<select name="id_empresa" required>
										
						<?php
							try {
								bd_printOptionsEmpresas();							
							}
							catch (Exception $objE) {
								echo '</select>';
								die('Erro: ' . $objE->getMessage());
							}
						?>
						
					</select><br/>
			<?php
				}
				else {
					echo '<input name="id_empresa" type="hidden" value="'.$_SESSION['id_empresa'].'"></input>';
				}
			?>			
			<button type='submit'>Inserir</button>
		</form>
	</body>
</html>