<!DOCTYPE html>

<?php
	require_once ('layoutUp.php');
	require_once('scripts/functions.php');
	session_validaLoginRedirect('adminGeral','adminDeus');
?>

<html lang="pt-BR">
	<head>
		<title>Visualizar Usuário</title>
	</head>
	
	<body>
<?php
	
	$intIdUsuario = $_GET['num'];
	
	$mysqli = bd_conecta();
		
		
		#consulta SQL: Fazendo a junção de tabelas e renomeando a coluna empresas.nome para empresa.
		
		$strSql = "select empresas.nome 'empresa', usuarios.nome, usuarios.email, usuarios.nivel, usuarios.ativo 
					from usuarios, empresas 
					where usuarios.id = $intIdUsuario and empresas.id = usuarios.id_empresa";
		
		$query = $mysqli->query($strSql);
		
		if($query){
			
					while ($dados = $query->fetch_array()) { #indexação pelo nome ou indice
							
							echo 'Nome: ' . $dados['nome'] . '<br>';	
												
							echo 'Email: ' . $dados['email'] . '<br>';
							
							echo 'Nível: '. $dados['nivel'] . '<br>';
																					
							echo 'Empresa: ' . $dados['empresa'] . '<br>';
							
							echo 'Ativo: ' . $dados['ativo'] . '<br>';
							
							echo '<a href="editarUsuario.php">Editar</a>';
							
							echo '<br>';
							
							echo '<a href="excluirUsuario.php">Excluir</a>';
							
							echo '<br><br>';
						}
						
						mysqli_free_result($query);

						mysqli_close($mysqli);
			}
						require 'layoutDown.php';
?>

	 </body>
	 
</html>
