<!DOCTYPE html>
<?php
	require_once('scripts/functions.php');

	//Acesso permitido somente a usuários de nível adminGeral ou adminDeus
	session_validaLoginRedirect('adminGeral','adminDeus');

	class Usuario {
		public $strNome;
		public $strEmail;
		public $strSenha;
		public $strNivel;
		public $intIdEmpresa;
		public $intAtivo;
	}

	//Caso de Uso: Inserir Usuário
	//TODO: Armazenar senha em HASH e valida senha usando HASH
	function insereUsuario($objUsuario) {

		$objMysqli = bd_conecta();
		
		//Cria comando SQL
		$strSQL = 'INSERT INTO usuarios(nome,email,senha,nivel,id_empresa,ativo)'.'VALUES (?,?,?,?,?,?);';
		$objStmt = $objMysqli->prepare($strSQL);

		//Informa mensagem de erro na criação do comando SQL
		if(!$objStmt) {
			throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
		}

		//Preenche parâmetros SQL de forma segura
		$objStmt->bind_param('ssssii',
			$objUsuario->strNome,
			$objUsuario->strEmail,
			$objUsuario->strSenha,
			$objUsuario->strNivel,
			$objUsuario->intIdEmpresa,
			$objUsuario->intAtivo);		
		$ok = $objStmt->execute();
		
		//Tratamento do resultado da operação
		if(!$ok) {			
			throw new Exception($objMysqli->errno .', ' . $objMysqli->error);
		}
		
		//Finaliza conexão ao BD
		$objStmt->close();
		$objMysqli->close();
		
	}

	//Se a página está sendo carregada logo após o formulário ter sido preenchido e enviado.
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//Recupera informações a serem armazenadas
		$objUsuario = new Usuario();
		$objUsuario->strNome = (!empty($_POST['nome']) ? $_POST['nome'] : null);
		$objUsuario->strEmail = (!empty($_POST['email']) ? $_POST['email'] : null);
		$objUsuario->strSenha = (!empty($_POST['senha']) ? sha1($_POST['senha']) : null);
		$objUsuario->strNivel = (!empty($_POST['nivel']) ? $_POST['nivel'] : null);
		$objUsuario->intIdEmpresa = (!empty($_POST['id_empresa']) ? $_POST['id_empresa'] : null);
		$objUsuario->intAtivo = 1;

		//Todos os campos são obrigatórios
		if (!$objUsuario->strNome || !$objUsuario->strEmail || !$objUsuario->strSenha || !$objUsuario->strNivel || !$objUsuario->intIdEmpresa) {
			setaMensagem('Existe(m) campos(s) obrigatórios(s) em branco.', 'erro');
		} 
		else {
			try {
				insereUsuario($objUsuario);
				setaMensagem('Usuário inserido com sucesso.', 'sucesso');
			}
			catch (Exception $objE) {
				setaMensagem($objE->getMessage(), 'erro');
			}
		}
	}

?>

<html>
	<head>
		<title>Formulário de inserção de usuário</title>
	</head>
	<body>
		<?php require('layoutUp.php'); ?>
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
								setaMensagem($objE->getMessage(), 'erro');
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
		<?php require('layoutDown.php'); ?>
	</body>
</html>